<?php
namespace Test3;

class newBase
{
    static private $count = 0;
    static private $arSetName = [];
    /**
     * @param string $name
     */
    function __construct(int $name = 0)
    {
        if (empty($name)) {
//            while (array_search(self::$count, self::$arSetName) != false) {
            while (array_search(self::$count, self::$arSetName)) {
                ++self::$count;
            }
            $name = self::$count;
        }
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }
//    private $name;
    protected $name;
    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }
    protected $value;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this; // Добавил
    }
    /**
     * @return string
     */
    public function getSize()
    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }
    public function __sleep()
    {
        return ['value'];
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
//        $value = serialize($value);
        $value = serialize($this->value);
//        return $this->name . ':' . sizeof($value) . ':' . $value;
        return $this->name . ':' . strlen($value) . ':' . $value;
    }
    /**
     * @return newBase
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        return (new newBase($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
//                + strlen($arValue[1]) + 1), $arValue[1]));
                + strlen($arValue[1]) + 1, $arValue[1])));
    }
}
class newView extends newBase
{
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
        return $this; // Добавил
    }
    public function setProperty($value)
    {
        $this->property = $value;
        return $this;
    }
    private function setType()
    {
        $this->type = gettype($this->value);
    }
    private function setSize()
    {
//        if (is_subclass_of($this->value, "Test3\newView")) {
        if (is_subclass_of($this->value, 'Test3\newView')) {
            $this->size = parent::getSize() + 1 + strlen($this->property);
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = strlen($this->value);
        }
    }
    /**
     * @return string
     */
    public function __sleep()
    {
        return ['property'];
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        if (empty($this->name)) {
//            throw new Exception('The object doesn\'t have name');
            throw new \Exception('The object doesn\'t have name');
        }
        return '"' . $this->name  . '": ';
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type  . ';';
    }
    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }
    public function getInfo()
    {
        try {
            echo $this->getName()
                . $this->getType()
                . $this->getSize()
                . "\r\n";
//        } catch (Exception $exc) {
        } catch (\Exception $exc) {
            echo 'Error: ' . $exc->getMessage();
        }
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
//        if ($this->type == 'test') {
        if ($this->type == 'test' && is_object($this->value)) {
            $this->value = $this->value->getSave();
        }
        return parent::getSave() . serialize($this->property);
    }
    /**
     * @return newView
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
//        return (new newBase($arValue[0]))
        return (new newView($arValue[0]))
            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
//                + strlen($arValue[1]) + 1), $arValue[1]))
                + strlen($arValue[1]) + 1, $arValue[1])))
            ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1 + $arValue[1])))
            ;
    }
}
function gettype($value): string
{
    if (is_object($value)) {
        $type = get_class($value);
        do {
//            if (strpos($type, "Test3\newBase") !== false) {
            if (strpos($type, 'Test3\newBase') !== false) {
                return 'test';
            }
        } while ($type = get_parent_class($type));
    }
//    return gettype($value);
    return \gettype($value);
}


$obj = new newBase('12345');
$obj->setValue('text');

//$obj2 = new \Test3\newView('O9876');
$obj2 = new newView('9876');
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();

$save = $obj2->getSave();

$obj3 = newView::load($save);

var_dump($obj2->getSave() == $obj3->getSave());


##         Вопросы:        ##
//
// В конструкторе установлен входящий тип целочисленный, а при создании объекта передается буква.
// 1. Значит при создании объекта ошибочно стоит буква (O`9876)?
// 2. Или что-то нужно было добавить в проверке в конструкторе?
//
// В конструкторе в условии используется сравнение != false, хотя это бессмысленно
// Это считается ошибкой?
//
// Для каких целей используется массив и счетчик в статике в первом классе?
// В массив записывается name, либо счетчик при выполнений условия на пустое значение.
//
// Для каких целей прописан метод getName в первом классе, если он не используется?
// Или может я не додумался и он все же применяется при прочих условиях.
//
// __sleep во втором классе не задействуется. В использовании этого метода есть какой-либо смысл?
//
// Зачем дублируется метод load в первом классе?
