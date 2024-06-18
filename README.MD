## Установка

composer require evgenyart/util-translit

## Использование

```php <?php  
$util = new UtilTranslit();
echo $util->translit("Какой-то текст", $params = []);
```    
    
 ### Параметры
 
 * change_case - все символы в одном регистре (возможные значения L - в нижнем регистре, U - в верхнем регистре, false - не изменять регистр. По-умолчанию change_case = "L")
 * replace_space - заменять пробелы (возможные значения - любой символ, false - оставить пробелы. По-умолчания replace_space  = "-"
 * replace_other - заменять другие символы (кроме кириллицы, латиницы, цифр и пробелов.  возможные значения - любой символ, false - оставлять другие символы. По-умолчанию replace_other = "-")
 * delete_repeat_replace - удалить более 1 пробела подряд. Возможные значения true - удалить повторяющиеся значения пробелов, false - не удалять повторяющиеся пробелы. Значение по-умолчанию delete_repeat_replace = true

### Пример вызова с параметрами:

```php <?php
$util = new UtilTranslit();
echo $util->translit("Какой-то текст", ['change_case' => false, 'replace_space' => false]);
```
    
    