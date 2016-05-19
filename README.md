## Описание

Генерация ответов сервера в формате JSend (see https://labs.omniti.com/labs/jsend).
Package содержит следующие классы:

#### TRS\RestResponse\interfaces
TemplateInterface
#### TRS\RestResponse\templates
BaseTemplate
#### TRS\RestResponse\jsend
Response

## Пример

```php

// your template class
// templates needs for formating data section in response (remove some data for example)
use TRS\RestResponse\templates\BaseTemplate
class ProductSmallTemplate extends BaseTemplate
{
    protected function prepareResult()
        {
            $this->result = [
                'id'          => $this->model->id,
                'title'       => $this->model->title,
                'description' => $this->model->description,
                // exclude other fields (prices, discounts etc.)
            ];
        }
}

// model
class Product extends BaseProduct
{
    // you can use any other method name
    public function getAsArray($template = 'small')
        {
            if ($template == 'small') {
                $template = new ProductSmallTemplate($this);
            } else {
                throw new \InvalidArgumentException('Invalid template "' . $template . '"');
            }
            return [ 'Product' => $template->getAsArray() ];
        }
}

// controller
use TRS\RestResponse\jsend\Response
class ProductsController extends BaseController
{
    public function actionShow($id)
    {
        $product = Product::find()->localized()->andWhere(['id' => $id])->one();
        Response::success($product->getAsArray('small'))->send();
    }
}

```

## Установка

Для того чтобы установить пакет через composer необходимо в вашем `composer.json` указать дополнительный источник
(так как данный пакет не лежит в открытом доступе), и указать сам пакет.

```
...
"repositories": [
		...
        {
            "type": "git",
            "url": "https://git.therealstart.com/sandbox/yii2-rest-response.git"
        }
        ...
    ],
...
"require": {
...
	"the-real-start/yii2-rest-response": "*"
}
...

```

После установки все классы расширения доступны по namespace-у `TRS\RestResponse`.

## Документация

Код по возможности был хорошо задокументирован и позволяет сформировать читабельный `phpdoc`.

Вкратце опишу как сгенерировать документацию.

### Генерация phpdoc

Комманда для геренации документации по коду:

```
phpdoc run -d ./ -t doc/ -i vendor/
```
