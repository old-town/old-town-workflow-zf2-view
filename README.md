# workflow-zf2-view

[![Build Status](https://secure.travis-ci.org/old-town/workflow-zf2-view.svg?branch=dev)](https://secure.travis-ci.org/old-town/workflow-zf2-view)
[![Coverage Status](https://coveralls.io/repos/old-town/workflow-zf2-view/badge.svg?branch=dev&service=github)](https://coveralls.io/github/old-town/workflow-zf2-view?branch=dev)

# Функционал модуля
Модуль реализующий отображения результатов работы workflow.

Модуль реализует обработчик [RenderWorkflowResult](./src/Listener/RenderWorkflowResult.php)  события render, которое бросается модулем [old-town/workflow-zf2-view](https://github.com/old-town/workflow-zf2).

Данный обработчик делегирует фунции по отображению результатов работы workflow, соответствующемeу handler'у.


# Handler

## Базовые понятия

ViewHandler - это объект класса который реализует [HandlerInterface](./src/Handler/HandlerInterface.php). Эти обработчики
сосредотачивают в себе всю логику по подготовке и отображению результатов работы workflow.
 
Переход в новое состояние workflow, описывается с помощью специального дескриптора \OldTown\Workflow\Loader\ActionDescriptor.
В конфигурационном файле workflow данном дескриптору соответствуют тег - action. У данного теге есть необезательный 
аттрибут view. Именно его значение определяет какой Handler будет использоваться. 

Для большего удобства и гибкости настроек модуль предоставляет [HandlerPluginManager](./src/Handler/Manager.php). Который можно получить из 
ServiceLocator основного приложения.

```php
    /** @var \OldTown\Workflow\ZF2\View\Handler\Manager $handlerManager */
    $handlerManager = $serviceLocator->get(\OldTown\Workflow\ZF2\View\Handler\Manager::class);

```

Для получения настроенного экземпляра handler'a необходимо воспользоваться абстрактной фабрикой [HandlerAbstractFactory](./src/Handler/HandlerAbstractFactory.php).
Пример получения настроенного экземпляра handler'a:

```php
    /** @var \OldTown\Workflow\ZF2\View\Handler\Manager $handlerManager */
    $handlerManager = $serviceLocator->get(\OldTown\Workflow\ZF2\View\Handler\Manager::class);
    /** @var \OldTown\Workflow\ZF2\View\Handler\HandlerInterface $handler */
    $handler = $handlerManager->get('workflow.view.handler.ИМЯ_VIEW');
```

В приведенном выше примере:
* ИМЯ_VIEW - это значение атрибута view тега action, из xml файла описывающего workflow/

## Настройка абстрактной фабрики для создания handler'ов
Для того что бы зарегестрировать свой handler, с заданным именем, необходимо в конфиги приложения в секцию 
[workflow_zf2_view][view] добавть описание соответствующего хендлера. Пример конфига:

```php
<?php

use Application\Listener\TestViewHandler;

return [
    'workflow_zf2_view' => [
        'view' => [
            //Имя вида. Совпадает с значением атрибута view у ActionDescriptor
            'test' => [
                //Ключ по которому будет получаться шаблон у соответствующего рендерера
                'template' => 'application/test-zf2-view/test-view',
                //Обработчик в котором реализована логика отображения результатов workflow
                'handler' => TestViewHandler::class
            ]
        ]
    ]
];
```

В данном примере зарегестрирован handler, для вида "test". Настройки handler'a описываются массивом со следующей структурой:

* template - необязательный параметр. Если он задан то в качестве шаблона отображения, будет использоваться шаблон, доступный по данному ключу.
* handler - необезательный параметр. Если он не указан, то в качестве handler'a используется [DefaultHandler](./src/Handler/DefaultHandler.php).
Если указан, то будет произведена попытка создать экземпляр handler'а  с пощмощью [HandlerPluginManager](./src/Handler/Manager.php).
Таким образом, значение параметра handler, является именем сервиса для [HandlerPluginManager](./src/Handler/Manager.php).

## Создание собственного handler'a на основе AbstractHandler

В случае если необходимо реализовать собственный handler, самым простым способом сделать это, будет создание класса handler'a
отнаследованного от [AbstractHandler](./src/Handler/AbstractHandler.php). Создание собственного handler'a может потребоваться
если необходимо релизовать подготовку данных полученных из workflow (transientVars), для дальнейшего отображения.

Созданный handler'необходимо зарегестрировать в  [HandlerPluginManager](./src/Handler/Manager.php). Это можно сделать
добавив соответствующую запись в секции конфигов приложения

```php
    'workflow_zf2_view_handler' => [
        'factories'          => [],
        'invokables'         => [
            MyClass::class => MyClass::class
        ],
        'abstract_factories' => [],
        'aliases'            => [
            'default' => DefaultHandler::class
        ]
    ],
```

## Принцип работы AbstractHandler

Запуск процесса отображения результатов работы workflow, начинается с вызовам метода run. Данный метод в качестве аргумента
принимает единственный параметр - объект реализующий [ContextInterface](./src/Handler/Context/ContextInterface.php).

[AbstractHandler](./src/Handler/AbstractHandler.php) имеет свой менеджер событий. При вызове метода run, бросаются
следующие события:

* bootstrap - инициализация handler'a
* template.resolve - определение имени шаблона для отображения
* dispatch - подготовка данных для отображения

[AbstractHandler](./src/Handler/AbstractHandler.php) сам подписан на все перечисленные события. В случае если реализуется
свой handler, то чаще всего будет перегружаться метод dispatch. Именно этот метод является обработчиком для одноименного события.
То что возвращает данный метод, будет переданно в шаблон используемый для отображения результатов работы workflow.

## Изменения поведения handler'ов из других модулей

Если возникла необходимость повлиять на работу handler'а из другого модуля, то достаточно получить зарегестрированный 
handler' через абстрактную фабрику, и подписаться на соответствующее событие 

```php
    /** @var \OldTown\Workflow\ZF2\View\Handler\Manager $handlerManager */
    $handlerManager = $serviceLocator->get(\OldTown\Workflow\ZF2\View\Handler\Manager::class);
    /** @var \OldTown\Workflow\ZF2\View\Handler\HandlerInterface $handler */
    $handler = $handlerManager->get('workflow.view.handler.ИМЯ_VIEW')
    $handler->getEventManager()->attach('dispatch', function(\OldTown\Workflow\ZF2\View\Handler\Context\HandlerContext $context) {
        //Свой код
    });

```



