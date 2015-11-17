<?php

/**
 * Pro pohodlnou práci s twitter bootstrap
 * běžně používané prvky UI
 *
 * @package    EaseFrameWork
 * @subpackage EaseHtml
 * @author     Vítězslav Dvořák <vitex@hippy.cz>
 * @copyright  2012 Vitex@vitexsoftware.cz (G)
 * @link       http://twitter.github.com/bootstrap/index.html
 */
require_once 'EaseWebPage.php';
require_once 'EaseJQuery.php';
require_once 'EaseHtmlForm.php';

/**
 * Twitter Bootstrap common class
 *
 * @author Vitex <vitex@hippy.cz>
 */
class EaseTWBPart extends EaseJQueryPart
{

    /**
     * Vložení náležitostí pro twitter bootstrap
     */
    public function __construct()
    {
        parent::__construct();
        self::twBootstrapize();
    }

    /**
     * Opatří objekt vším potřebným pro funkci bootstrapu
     *
     */
    public static function twBootstrapize()
    {
        parent::jQueryze();
        $webPage = EaseShared::webPage();
        $webPage->includeJavaScript('twitter-bootstrap/js/bootstrap.js', 1, true);
        if (isset($webPage->mainStyle)) {
            $webPage->includeCss($webPage->mainStyle, true);
        }
//TODO: ONCE: $webPage->head->addItem('<meta name="viewport"
// content="width=device-width, initial-scale=1.0">');
        return true;
    }

    /**
     * Vrací ikonu
     *
     * @link  http://getbootstrap.com/components/#glyphicons Přehled ikon
     * @param string $code Kód ikony z přehledu
     * @param array $properties Vlastnosti Tagu
     */
    public static function GlyphIcon($code, $properties = null)
    {
        if (is_null($properties)) {
            $properties = array('class' => 'glyphicon glyphicon-' . $code);
        } else {
            if (isset($properties['class'])) {
                $properties['class'] = 'glyphicon glyphicon-' . $code . ' ' . $properties['class'];
            } else {
                $properties['class'] = 'glyphicon glyphicon-' . $code;
            }
        }
        return new EaseHtmlSpan(null, $properties);
    }

}

/**
 * Stránka TwitterBootstrap
 */
class EaseTWBWebPage extends EaseWebPage
{

    /**
     * CSSKo bootstrapu
     * @var string url
     */
    public $mainStyle = 'twitter-bootstrap/css/bootstrap.css';

    /**
     * Stránka s podporou pro twitter bootstrap
     *
     * @param string   $pageTitle
     * @param EaseUser $userObject
     */
    public function __construct($pageTitle = null)
    {
        parent::__construct($pageTitle);
        $this->includeCss($this->mainStyle, true);
        $this->head->addItem(
            '<meta name="viewport" content="width=device-width,initial-scale=1.0">'
        );
    }

    /**
     * Vrací zprávy uživatele
     *
     * @param string $what info|warning|error|success
     *
     * @return string
     */
    public function getStatusMessagesAsHtml($what = null)
    {
        /**
         * Session Singleton Problem hack
         */
//$this->easeShared->takeStatusMessages(EaseShared::user()->getStatusMessages(true));

        if (!count($this->easeShared->statusMessages)) {
            return '';
        }
        $htmlFargment = '';

        $allMessages = array();
        foreach ($this->easeShared->statusMessages as $quee => $messages) {
            foreach ($messages as $MesgID => $message) {
                $allMessages[$MesgID][$quee] = $message;
            }
        }
        ksort($allMessages);
        foreach ($allMessages as $message) {
            $messageType = key($message);

            if (is_array($what)) {
                if (!in_array($messageType, $what)) {
                    continue;
                }
            }

            $message = reset($message);

            if (is_object($this->logger)) {
                if (!isset($this->logger->logStyles[$messageType])) {
                    $messageType = 'notice';
                }
                if ($messageType == 'error') {
                    $messageType = 'danger';
                }
                $htmlFargment .= '<div class="alert alert-' . $messageType . '" >' . $message . '</div>' . "\n";
            } else {
                $htmlFargment .= '<div class="alert">' . $message . '</div>' . "\n";
            }
        }

        return $htmlFargment;
    }

}

/**
 * Odkazové tlačítko twbootstrabu
 *
 * @author     Vítězslav Dvořák <vitex@hippy.cz>
 * @copyright  2012 Vitex@vitexsoftware.cz (G)
 * @link       http://twitter.github.com/bootstrap/base-css.html#buttons Buttons
 */
class EaseTWBLinkButton extends EaseHtmlATag
{

    /**
     * Odkazové tlačítko twbootstrabu
     *
     * @param string $href       cíl odkazu
     * @param mixed  $contents   obsah tlačítka
     * @param string $type       primary|info|success|warning|danger|inverse|link
     * @param array  $properties dodatečné vlastnosti
     */
    public function __construct($href, $contents = null, $type = null, $properties = null)
    {

        if (isset($properties['class'])) {
            $class = ' ' . $properties['class'];
        } else {
            $class = '';
        }
        if (is_null($type)) {
            $properties['class'] = 'btn btn-default';
        } else {
            $properties['class'] = 'btn btn-' . $type;
        }

        $properties['class'] .= $class;

        parent::__construct($href, $contents, $properties);
        EaseTWBPart::twBootstrapize();
    }

}

/**
 * Odesílací tlačítko formuláře Twitter Bootstrapu
 */
class EaseTWSubmitButton extends EaseHtmlButtonTag
{

    /**
     * Odesílací tlačítko formuláře Twitter Bootstrapu
     *
     * @param string $value vracená hodnota
     * @param string $type  primary|info|success|warning|danger|inverse|link
     */
    public function __construct($value = null, $type = null, $properties = null)
    {
        if (is_null($type)) {
            $properties['class'] = 'btn';
        } else {
            $properties['class'] = 'btn btn-' . $type;
        }
        parent::__construct($value, $properties);
        EaseTWBPart::twBootstrapize();
    }

}

/**
 *  NavBar
 */
class EaseTWBNavbar extends EaseHtmlDivTag
{

    /**
     * Vnitřek menu
     * @var EaseHtmlDivTag
     */
    public $menuInnerContent = null;

    /**
     * Položky menu
     * @var EaseHtmlUlTag
     */
    private $nav;

    /**
     * Položky menu přidávané vpravo
     * @var EaseHtmlUlTag
     */
    private $navRight;

    /**
     * Menu aplikace
     *
     * @param string $name
     * @param string $brand
     * @param array  $properties
     */
    public function __construct($name = null, $brand = null, $properties = null)
    {
        if (is_null($properties)) {
            $properties = array('class' => 'navbar navbar-default');
        } else {
            if (isset($properties)) {
                $properties['class'] = 'navbar navbar-default ' . $properties['class'];
            } else {
                $properties['class'] = 'navbar navbar-default';
            }
        }
        $properties['role'] = 'navigation';
        parent::__construct($name, null, $properties);
        $this->menuInnerContent = parent::addItem(new EaseHtmlDivTag(null, null, array('class' => 'navbar-inner')));

        $this->addItem(self::NavBarHeader($name, $brand));

        $navCollapse = $this->addItem(new EaseHtmlDivTag(null, null, array('class' => 'collapse navbar-collapse navbar-' . $name . '-collapse')));
        $this->nav = $navCollapse->addItem(new EaseHtmlUlTag(null, array('class' => 'nav navbar-nav')));
        $this->tagType = 'nav';
        $pullRigt = new EaseHtmlDivTag(NULL, null, array('class' => 'pull-right'));
        $this->navRight = $pullRigt->addItem(new EaseHtmlUlTag(null, array('class' => 'nav navbar-nav nav-right')));
        $navCollapse->addItem($pullRigt);
        EaseTWBPart::twBootstrapize();
    }

    public static function NavBarHeader($handle, $brand)
    {
        $navstyle = '.navbar-' . $handle . '-collapse';
        $nbhc['button'] = new EaseHtmlButtonTag(array(
          new EaseHtmlSpanTag(null, _('přepnutí navigace'), array('class' => 'sr-only')),
          new EaseHtmlSpanTag(null, null, array('class' => 'icon-bar')),
          new EaseHtmlSpanTag(null, null, array('class' => 'icon-bar')),
          new EaseHtmlSpanTag(null, null, array('class' => 'icon-bar'))
            ), array('type' => 'button', 'class' => 'navbar-toggle', 'data-toggle' => 'collapse', 'data-target' => $navstyle));

        if ($brand) {
            $nbhc['brand'] = new EaseHtmlATag('./', $brand, array('class' => 'navbar-brand'));
        }

        return new EaseHtmlDivTag(null, $nbhc, array('class' => 'navbar-header'));
    }

    /**
     * Přidá položku do navigační lišty
     *
     * @param mixed  $Item         vkládaná položka
     * @param string $PageItemName Pod tímto jménem je objekt vkládán do stromu
     *
     * @return EasePage poiner to object well included
     */
    function & addItem($Item, $PageItemName = null)
    {
        $added = $this->menuInnerContent->addItem($Item, $PageItemName);
        return $added;
    }

    /**
     * Přidá položku menu
     *
     * @param EaseHtmlATag $pageItem Položka menu
     * @param string       $pull     'right' strká položku v menu do prava
     *
     * @return EaseWebPage
     */
    function &addMenuItem($pageItem, $pull = 'left')
    {
        if ($pull == 'left') {
            $menuItem = $this->nav->addItemSmart($pageItem);
        } else {
            $menuItem = $this->navRight->addItemSmart($pageItem);
        }
        if (isset($pageItem->tagProperties['href'])) {
            $href = basename($pageItem->tagProperties['href']);
            if (strstr($href, '?')) {
                list($targetPage, $params) = explode('?', $href);
            } else {
                $targetPage = $href;
            }
            if ($targetPage == basename(EasePage::phpSelf())) {
                if ($pull == 'left') {
                    $this->nav->lastItem()->setTagProperties(array('class' => 'active'));
                } else {
                    $this->navRight->lastItem()->setTagProperties(array('class' => 'active'));
                }
            }
        }

        return $menuItem;
    }

    function & addDropDownSubmenu($name, $items)
    {
        $dropdown = $this->addItem(new EaseHtmlUlTag(null, array('class' => 'dropdown-menu', 'role' => 'menu')));

        if (count($items)) {
            foreach ($items as $item) {
                $this->addMenuItem($item);
            }
        }
        return $dropdown;
    }

    /**
     * Vloží rozbalovací menu
     *
     * @param  string         $label popisek menu
     * @param  array|string   $items položky menu
     * @param  string         $pull  směr zarovnání
     * @return \EaseHtmlULTag
     */
    function & addDropDownMenu($label, $items, $pull = 'left')
    {
        EaseTWBPart::twBootstrapize();
        EaseShared::webPage()->addJavaScript('$(\'.dropdown-toggle\').dropdown();', null, true);
        $dropDown = new EaseHtmlLiTag(null, array('class' => 'dropdown', 'id' => $label));
        $dropDown->addItem(
            new EaseHtmlATag('#' . $label . '', $label . '<b class="caret"></b>', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'))
        );
        $dropDownMenu = $dropDown->addItem(new EaseHtmlUlTag(null, array('class' => 'dropdown-menu')));
        if (is_array($items)) {
            foreach ($items as $target => $label) {
                if (is_array($label)) { //Submenu
                    $dropDownMenu->addItem($this->addDropDownSubmenu($target, $label));
                } else { //Item
                    if (!$target) {
                        $dropDownMenu->addItem(new EaseHtmlLiTag(null, array('class' => 'divider')));
                    } else {
                        $dropDownMenu->addItemSmart(new EaseHtmlATag($target, $label));
                    }
                }
            }
        } else {
            $dropDownMenu->addItem($items);
        }
        if ($pull == 'left') {
            $this->nav->addItemSmart($dropDown);
        } else {
            $this->navRight->addItemSmart($dropDown);
        }

        return $dropDown;
    }

}

/**
 * Formulář Bootstrapu
 */
class EaseTWBForm extends EaseHtmlForm
{

    /**
     * Formulář Bootstrapu
     *
     * @param string $formName      jméno formuláře
     * @param string $formAction    cíl formulář např login.php
     * @param string $formMethod    metoda odesílání POST|GET
     * @param mixed  $formContents  prvky uvnitř formuláře
     * @param array  $tagProperties vlastnosti tagu například:
     *                              array('enctype' => 'multipart/form-data')
     */
    public function __construct($formName, $formAction = null, $formMethod = 'post', $formContents = null, $tagProperties = null)
    {
        if (!isset($tagProperties['class'])) {
            $tagProperties['class'] = 'form-horizontal';
        } else {
            if (!strstr($tagProperties['class'], 'form')) {
                $tagProperties['class'] = 'form-horizontal';
            }
        }
        $tagProperties['role'] = 'form';
        parent::__construct($formName, $formAction, $formMethod, $formContents, $tagProperties);
    }

    /**
     * Vloží prvek do formuláře
     *
     * @param mixed $input        Vstupní prvek
     * @param string $caption     Popisek
     * @param string $placeholder předvysvětlující text
     * @param string $helptext    Dodatečná nápověda
     */
    public function addInput($input, $caption = null, $placeholder = null, $helptext = null)
    {
        return $this->addItem(new EaseTWBFormGroup($caption, $input, $placeholder, $helptext));
    }

    /**
     * Vloží další element do formuláře a upraví mu css
     *
     * @param mixed  $pageItem     hodnota nebo EaseObjekt s metodou draw()
     * @param string $pageItemName Pod tímto jménem je objekt vkládán do stromu
     *
     * @return pointer Odkaz na vložený objekt
     */
    function &addItem($pageItem, $pageItemName = null)
    {
        if (is_object($pageItem) && method_exists($pageItem, 'setTagClass')) {
            if (strtolower($pageItem->tagType) == 'select') {
                $pageItem->setTagClass(trim(str_replace('form_control', '', $pageItem->getTagClass() . ' form-control')));
            }
        }
        $added = parent::addItem($pageItem, $pageItemName);
        return $added;
    }

}

/**
 * Položka TWBootstrp formuláře
 *
 * @param string      $label       popisek pole formuláře
 * @param EaseHtmlTag $content     widget formuláře
 * @param string      $placeholder předvysvětlující text
 * @param string      $helptext    Nápvěda pod prvkem
 * @param string $addTagClass CSS třída kterou má být oskiován vložený prvek
 */
class EaseTWBFormGroup extends EaseHtmlDivTag
{

    public function __construct($label = null, $content = null, $placeholder = null, $helptext = null, $addTagClass = 'form-control')
    {
        $formKey = self::lettersOnly($label);

        $properties['class'] = 'form-group';
        parent::__construct(null, null, $properties);
        $this->addItem(new EaseHtmlLabelTag($formKey, $label));

        $content->addTagClass($addTagClass);
        if ($placeholder) {
            $content->SetTagProperties(array('placeholder' => $placeholder));
        }
        $content->setTagId($formKey);

        $this->addItem($content);
        if ($helptext) {
            $this->addItem(new EaseHtmlPTag($helptext, array('class' => 'help-block')));
        }
    }

}

/**
 * Vypisuje stavové hlášky
 */
class EaseTWBStatusMessages extends EaseHtmlDivTag
{

    /**
     * Blok stavových zpráv
     */
    public function __construct()
    {
        $properties['class'] = 'well';
        $properties['id'] = 'StatusMessages';
        $properties['title'] = _('kliknutím skryjete zprávy');
        $properties['style'] = 'padding-top: 40px; padding-bottom: 0px;';
        parent::__construct(null, null, $properties);
        EaseJQueryPart::jQueryze();
        $this->addJavaScript('$("#StatusMessages").click(function () { $("#StatusMessages").fadeTo("slow",0.25).slideUp("slow"); });', 3, true);
    }

    /**
     * Vypíše stavové zprávy
     */
    public function draw()
    {
        $StatusMessages = trim($this->webPage->getStatusMessagesAsHtml());
        if ($StatusMessages) {
            parent::addItem($StatusMessages);
            parent::draw();
        } else {
            $this->suicide();
        }
    }

}

/**
 * Create TWBootstrap tabs
 *
 * @see http://getbootstrap.com/2.3.2/components.html#navs
 * @author Vítězslav Dvořák <vitex@hippy.cz>
 */
class EaseTWBTabs extends EaseContainer
{

    /**
     * Název
     * @var string
     */
    public $partName = 'TWBTabs';

    /**
     * Array of tab names=>contents
     * @var array
     */
    public $tabs = array();

    /**
     * Jméno aktivního tabu
     * @var string
     */
    private $activeTab = null;

    /**
     * Create TWBootstrap tabs
     *
     * @param string $partName       - DIV id
     * @param array  $tabsList
     * @param array  $partProperties
     */
    public function __construct($partName, $tabsList = null, $tagProperties = null)
    {
        $this->partName = $partName;
        parent::__construct();
        if (is_array($tabsList)) {
            $this->tabs = array_merge($this->tabs, $tabsList);
        }
        if (!is_null($tagProperties)) {
            $this->setPartProperties($tagProperties);
        }
    }

    /**
     * Vytvoří nový tab a vloží do něj obsah
     *
     * @param string  $tabName    jméno a titulek tabu
     * @param mixed   $tabContent
     * @param boolean $active     Má být tento tab aktivní ?
     *
     * @return pointer odkaz na vložený obsah
     */
    function &addTab($tabName, $tabContent = null, $active = false)
    {
        if (is_null($tabContent)) {
            $tabContent = new EaseHtmlDiv;
        }
        $this->tabs[$tabName] = $tabContent;
        if ($active) {
            $this->activeTab = $tabName;
        }

        return $this->tabs[$tabName];
    }

    /**
     * Vrací ID tagu
     *
     * @return string
     */
    function getTagID()
    {
        return $this->partName;
    }

    /**
     * Vložení skriptu a divů do stránky
     */
    public function finalize()
    {
        if (is_null($this->activeTab)) {
            $this->activeTab = current(array_keys($this->tabs));
        }
        $tabsUl = $this->addItem(new EaseHtmlUlTag(null, array('class' => 'nav nav-tabs', 'id' => $this->partName)));
        foreach ($this->tabs as $tabName => $tabContent) {
            if ($tabName == $this->activeTab) {
                $tabsUl->addItem(new EaseHtmlLiTag(new EaseHtmlATag('#' . self::lettersOnly($tabName), $tabName, array('data-toggle' => 'tab')), array('class' => 'active')));
            } else {
                $tabsUl->addItem(new EaseHtmlLiTag(new EaseHtmlATag('#' . self::lettersOnly($tabName), $tabName, array('data-toggle' => 'tab'))));
            }
        }

        $tabDiv = $this->addItem(new EaseHtmlDivTag($this->partName . 'body', null, array('class' => 'tab-content')));
        foreach ($this->tabs as $tabName => $tabContent) {
            if ($tabName == $this->activeTab) {
                $tabDiv->addItem(new EaseHtmlDivTag(self::lettersOnly($tabName), $tabContent, array('class' => 'tab-pane active')));
            } else {
                $tabDiv->addItem(new EaseHtmlDivTag(self::lettersOnly($tabName), $tabContent, array('class' => 'tab-pane')));
            }
        }

        EaseTWBPart::twBootstrapize();
        EaseShared::webPage()->addJavaScript("
        $('#" . $this->partName . " a[href=\"#" . self::lettersOnly($this->activeTab) . "\"]').tab('show');
", NULL, true);
    }

}

class EaseTWGlyphIcon extends EaseHtmlSpanTag
{

    /**
     * Vloží ikonu
     *
     * @link  http://getbootstrap.com/components/#glyphicons Přehled ikon
     * @param string $code Kód ikony z přehledu
     */
    public function __construct($code)
    {
        parent::__construct(null, null, array('class' => 'glyphicon glyphicon-' . $code));
    }

}

class EaseTWBButtonDropdown extends EaseHtmlDiv
{

    /**
     * Rozbalovací nabídka
     * @var EaseHtmlUlTag
     */
    public $dropdown = null;

    /**
     *
     * @var type
     */
    public $button = null;

    /**
     * Tlačítko s rozbalovacím menu
     *
     * @param string $label      popisek tlačítka
     * @param string $type       primary|info|success|warning|danger|inverse|link
     * @param string $size       lg = velký, sm = menší, xs = nejmenší
     * @param array  $items      položky menu
     * @param array  $properties Parametry tagu
     */
    function __construct($label = null, $type = 'default', $size = null, $items = null, $properties = null)
    {
        parent::__construct(null, $properties);
        $this->setTagClass('btn-group');
        $btnClass = 'btn btn-' . $type . ' ';
        if ($size) {
            $btnClass .= 'btn-' . $size;
        }
        $this->button = $this->addItem(new EaseHtmlButtonTag(array($label . ' <span class="caret"></span>'), array('class' => $btnClass . ' dropdown-toggle', 'type' => 'button', 'data-toggle' => 'dropdown')));

        $this->dropdown = $this->addItem(new EaseHtmlUlTag(null, array('class' => 'dropdown-menu', 'role' => 'menu')));

        if (count($items)) {
            foreach ($items as $item) {
                $this->addMenuItem($item);
            }
        }
    }

    /**
     * Vloží položku do menu tlačítka
     *
     * @param type $pageItem
     * @return EaseHtmlLiTag
     */
    function addMenuItem($pageItem)
    {
        return $this->dropdown->addItemSmart($pageItem);
    }

    /**
     * delící čára menu
     *
     * @return \EaseHtmlLiTag
     */
    static function divider()
    {
        return new EaseHtmlLiTag(null, array('class' => 'divider'));
    }

}

class EaseTWBCheckBoxGroup extends EaseContainer
{

    /**
     *
     * @param array $items
     */
    public $items = array();

    function __construct($items)
    {
        $this->items = $items;
    }

    function finalize()
    {
        foreach ($this->items as $name => $value) {
            $this->addItem(new EaseTWBCheckbox($name, $value, $value, $checked));
        }
    }

}

class EaseTWRadioButtonGroup extends EaseContainer
{

    /**
     * Jméno
     * @var string
     */
    public $name = null;

    /**
     * Typ
     * @var bool
     */
    public $inline = false;

    /**
     * Položky k zobrazení
     * @var array
     */
    public $radios = array();

    /**
     * Předvolená hodnota
     * @var string
     */
    public $checked = null;

    /**
     * Zobrazí pole radiobuttonů
     *
     * @param string $name
     * @param array  $radios pole Hodnota=>Popisek
     * @param string $checked
     * @param boolean $inline
     */
    function __construct($name, $radios, $checked = null, $inline = false)
    {
        $this->name = $name;
        $this->checked = $checked;
        $this->inline = $inline;
        $this->radios = $radios;
        parent::__construct();
    }

    /**
     * Seskládá pole radiobuttonů
     */
    function finalize()
    {
        $class = 'radio';
        if ($this->inline) {
            $class .= '-inline';
        }
        $pos = 1;
        foreach ($this->radios as $value => $caption) {
            if ($value == $this->checked) {
                $checked = 'checked';
            } else {
                $checked = null;
            }

            $tagProperties = array(
              'id' => $this->name . $pos++,
              'name' => $this->name,
              $checked
            );

            $this->addItem(
                new EaseHtmlDivTag(
                null, new EaseHtmlLabelTag(
                null, array(
              new EaseHtmlInputRadioTag($this->name, $value, $tagProperties),
              $caption
                )
                ), array('class' => $class)
                )
            );
        }
    }

}

class EaseTWModal extends EaseHtmlDiv
{

    /**
     * Spodek dialogu s tlačítky
     * @var EaseHtmlDiv
     */
    public $footer;

    /**
     * Vlastnosti dialogu
     * @var array
     */
    private $properties;

    /**
     * Jméno dialogu
     * @var string
     */
    public $name;

    /**
     * Titulek dialogu
     * @var string
     */
    public $title;

    /**
     * Tělo dialogu
     * @var EaseHtmlDiv
     */
    public $body;

    /**
     * Hlavička dialogu
     * @var EaseHtmlDiv
     */
    public $header;

    /**
     * Vytvoří modální dialogs
     *
     * @param string $name
     * @param mixed  $content
     * @param array  $properties
     */
    function __construct($name, $title, $content = null, $properties)
    {
        parent::__construct(null, array('class' => "modal fade", 'id' => $name, 'tabindex' => "-1", 'role' => "dialog", 'aria-labelledby' => $title . 'ID', 'aria-hidden' => "true"));
        $this->properties = $properties;
        $this->name = $name;
        $this->title = $title;

        $this->header = new EaseHtmlDiv(null, array('class' => 'modal-header'));
        $this->header->addItem(new EaseHtmlButtonTag('&times;', array('class' => "close", 'data-dismiss' => "modal", 'aria-hidden' => "true")));

        $this->body = new EaseHtmlDiv($content, array('class' => 'modal-body'));

        $this->footer = new EaseHtmlDiv(null, array('class' => 'modal-footer'));
        $this->footer->addItem(new EaseHtmlButtonTag(_('Zavřít'), array('id' => $name . 'ko', 'type' => "button", 'class' => "btn btn-default", 'data-dismiss' => "modal")));
        $this->footer->addItem(new EaseHtmlButtonTag(_('Uložit'), array('id' => $name . 'ok', 'type' => "button", 'class' => "btn btn-primary")));
    }

    function finalize()
    {

        $modalDialog = $this->addItem(new EaseHtmlDiv(null, array('class' => 'modal-dialog')));

        $modalContent = $modalDialog->addItem(new EaseHtmlDiv(null, array('class' => 'modal-content')));

        $this->header->addItem(new EaseHtmlH4Tag($this->title, array('class' => 'modal-title', 'id' => $this->title . 'ID')));


        $modalContent->addItem($this->header);
        $modalContent->addItem($this->body);
        $modalContent->addItem($this->footer);


        if (is_array($this->properties)) {

            EaseShared::webPage()->addJavaScript(' $(function ()
{
    $("#' . $this->name . '").modal( {' . EaseTWBPart::partPropertiesToString($this->properties) . '});
});
', null, true);
        } else {
            EaseShared::webPage()->addJavaScript(' $(function ()
{
    $("#' . $this->name . '").modal( ' . $this->properties . ');
});
', null, true);
        }
    }

}

/**
 * Twitter Bootrstap Well
 */
class EaseTWBWell extends EaseHtmlDivTag
{

    /**
     * Twitter Bootrstap Well
     *
     * @param mixed $content
     */
    public function __construct($content = null, $properties = null)
    {
        parent::__construct(null, $content, $properties);
        $this->addTagClass('well');
    }

}

/**
 * Twitter Bootrstap Container
 */
class EaseTWBContainer extends EaseHtmlDivTag
{

    /**
     * Twitter Bootrstap Container
     *
     * @param mixed $content
     */
    public function __construct($content = null)
    {
        parent::__construct(null, $content, array('class' => 'container'));
    }

}

/**
 * Twitter Bootrstap Row
 */
class EaseTWBRow extends EaseHtmlDivTag
{

    /**
     * Twitter Bootrstap Row
     *
     * @param mixed $content Prvotní obsah
     */
    public function __construct($content = null)
    {
        parent::__construct(null, $content, array('class' => 'row'));
    }

    /**
     * Vloží do řádku políčko
     *
     * @link http://getbootstrap.com/css/#grid
     * @param int    $size       Velikost políčka 1 - 12
     * @param mixed  $content    Obsah políčka
     * @param string $target     Typ zařízení xs|sm|md|lg
     * @param array  $properties Další vlastnosti tagu
     */
    public function &addColumn($size, $content = null, $target = 'md', $properties = null)
    {
        $added = $this->addItem(new EaseTWBCol($size, $content, $target, $properties));
        return $added;
    }

}

class EaseTWBCol extends EaseHtmlDivTag
{

    /**
     * Bunka CSS tabulky bootstrapu
     *
     * @link http://getbootstrap.com/css/#grid
     * @param int    $size       Velikost políčka 1 - 12
     * @param mixed  $content    Obsah políčka
     * @param string $target     Typ zařízení xs|sm|md|lg
     * @param array  $properties Další vlastnosti tagu
     */
    function __construct($size, $content = null, $target = 'md', $properties = null)
    {
        if (is_null($properties)) {
            $properties = array();
        }
        $properties['class'] = 'col-' . $target . '-' . $size;
        parent::__construct(null, $content, $properties);
    }

}

/**
 * Panel Twitter Bootstrapu
 */
class EaseTWBPanel extends EaseHtmlDivTag
{

    /**
     * Hlavička panelu
     * @var EaseHtmlDivTag
     */
    public $heading = null;

    /**
     * Tělo panelu
     * @var EaseHtmlDivTag
     */
    public $body = null;

    /**
     * Patička panelu
     * @var EaseHtmlDivTag
     */
    public $footer = null;

    /**
     * Typ Panelu
     * @var string    succes|wanring|info|danger
     */
    public $type = 'default';

    /**
     * Obsah k přidání do patičky panelu
     * @var mixed
     */
    public $addToFooter = null;

    /**
     * Panel Twitter Bootstrapu
     *
     * @param string|mixed $heading
     * @param string       $type    succes|wanring|info|danger
     * @param mixes        $body    tělo panelu
     * @param mixed        $footer  patička panelu. FALSE = nezobrazit vůbec
     */
    function __construct($heading = null, $type = 'default', $body = null, $footer = null)
    {
        $this->type = $type;
        $this->addToFooter = $footer;
        parent::__construct(null, null, array('class' => 'panel panel-' . $this->type));
        if (!is_null($heading)) {
            $this->heading = parent::addItem(new EaseHtmlDivTag(null, $heading, array('class' => 'panel-heading')), 'head');
        }
        $this->body = parent::addItem(new EaseHtmlDivTag(null, $body, array('class' => 'panel-body')), 'body');
    }

    /**
     * Vloží další element do objektu
     *
     * @param mixed  $pageItem     hodnota nebo EaseObjekt s metodou draw()
     * @param string $pageItemName Pod tímto jménem je objekt vkládán do stromu
     *
     * @return pointer Odkaz na vložený objekt
     */
    function &addItem($pageItem, $pageItemName = null)
    {
        $added = $this->body->addItem($pageItem, $pageItemName);
        return $added;
    }

    /**
     * Vloží obsah do patičky
     */
    function finalize()
    {
        if (!count($this->body->pageParts)) {
            unset($this->pageParts['body']);
        }
        if ($this->addToFooter) {
            $this->footer()->addItem($this->addToFooter); //TODO: Bootstrap zatím neumí
        }
    }

    /**
     * Vrací patičku panelu
     *
     * @param mixed $content obsah pro vložení to patičky
     * @return EaseHtmlDivTag
     */
    public function footer($content = null)
    {
        if (is_object($this->footer)) {
            if ($content) {
                $this->footer->addItem($content);
            }
        } else {
            $this->footer = parent::addItem(new EaseHtmlDivTag(null, $content, array('class' => 'panel-footer panel-' . $this->type)), 'footer'); //TODO: Bootstrap zatím neumí
        }
        return $this->footer;
    }

}

class EaseTWBPagination extends EaseHtmlUlTag
{

    /**
     * Fragment adresy pro stránkování
     * @var string
     */
    public $url = '?page=';

    /**
     * Stránkování Twitter Bootrstap
     *
     * @param int    $pages   celkový počet stránek
     * @param int    $current aktuální stránka
     * @param string $url     Fragment adresy
     */
    function __construct($pages, $current, $url = '?page=')
    {
        $this->url = $url;
        parent::__construct(null, array('class' => 'pagination'));

        if (($current == 0)) {
            $this->addPage('#', EaseTWBPart::glyphIcon('fast-backward'), 'disabled');
        } else {
            $this->addPage(0, EaseTWBPart::glyphIcon('fast-backward'));
        }

        if (($current == 0)) {
            $this->addPage('#', EaseTWBPart::glyphIcon('chevron-left'), 'disabled');
        } else {
            $this->addPage($current - 1, EaseTWBPart::glyphIcon('chevron-left'));
        }


        for ($page = 0; $page <= $pages - 1; $page++) {
//Stavajici
            if ($current == $page) {
                $this->addPage($page, $page + 1, 'active');
            } else {
                $this->addPage($page, $page + 1);
            }
        }

        if ($current >= $pages - 1) {
            $this->addPage('#', EaseTWBPart::glyphIcon('chevron-right'), 'disabled');
        } else {
            $this->addPage($current + 1, EaseTWBPart::glyphIcon('chevron-right'));
        }

        if ($current >= $pages - 1) {
            $this->addPage('#', EaseTWBPart::glyphIcon('fast-forward'), 'disabled');
        } else {
            $this->addPage($pages - 1, EaseTWBPart::glyphIcon('fast-forward'));
        }
    }

    /**
     * Přidá krok strankování
     *
     * @param int $page
     * @param string $label
     */
    function addPage($page, $label = null, $style = null)
    {
        $link = $this->url . $page;
        if ($style) {
            $this->addItemSmart(new EaseHtmlATag($link, $label), array('class' => $style));
        } else {
            $this->addItemSmart(new EaseHtmlATag($link, $label));
        }
    }

}

/**
 * Checkbox pro TwitterBootstrap
 */
class EaseTWBCheckbox extends EaseHtmlDivTag
{

    /**
     * Odkaz na checkbox
     * @var  EaseHtmlCheckboxTag
     */
    public $checkbox = null;

    /**
     * Checkbox pro TwitterBootstrap
     *
     * @param string     $name
     * @param string|int $value
     * @param mixed      $content
     * @param bool       $checked
     * @param array      $properties
     */
    function __construct($name = null, $value = 'on', $content = null, $checked = false, $properties = null)
    {

        $label = new EaseHtmlLabelTag($name);
        $this->checkbox = $label->addItem(new EaseHtmlCheckboxTag($name, $checked, $value, $properties));
        if ($content) {
            $label->addItem($content);
        }
        parent::__construct($name, $label, $properties);
    }

}

/**
 * RadioButton Twitter Bootstrapu
 */
class EaseTWBRadioButton extends EaseHtmlDivTag
{

    /**
     *  RadioButton Twitter Bootstrapu
     *
     * @param string     $name
     * @param string|int $value
     * @param mixed      $caption
     * @param array      $properties
     */
    function __construct($name = null, $value = null, $caption = null, $properties = null)
    {
        if (isset($properties['id'])) {
            $for = $properties['id'];
        } else {
            $for = $name;
        }
        parent::__construct(
            null, new EaseHtmlLabelTag($for, array(new EaseHtmlInputRadioTag($name, $value, $properties), $caption))
        );
    }

}

/**
 * Návěstí bootstrapu
 */
class EaseTWBLabel extends EaseHtmlSpanTag
{

    /**
     * Návěstí bootstrapu
     *
     * @link http://getbootstrap.com/components/#labels
     *
     * @param string $type       info|warning|error|success
     * @param mixed  $content
     * @param array  $properties
     */
    function __construct($type = 'default', $content = null, $properties = null)
    {
        if (isset($properties['class'])) {
            $properties['class'].= ' label label-' . $type;
        } else {
            $properties['class'] = ' label label-' . $type;
        }
        parent::__construct(null, $content, $properties);
    }

}

/**
 * Odznak bootstrapu
 */
class EaseTWBBadge extends EaseHtmlSpanTag
{

    /**
     * Návěstí bootstrapu
     *
     * @link http://getbootstrap.com/components/#badges
     *
     * @param mixed  $content
     * @param array  $properties
     */
    function __construct($content = null, $properties = null)
    {
        parent::__construct(null, $content, $properties);
        $this->addTagClass('badge');
    }

}

/**
 * Textarea pro Twitter Bootstap
 *
 * @author vitex
 */
class EaseTWBTextarea extends EaseHtmlTextareaTag
{

    /**
     * Textarea
     *
     * @param string $name       jméno tagu
     * @param string $content    obsah textarey
     * @param array  $properties vlastnosti tagu
     */
    public function __construct($name, $content = '', $properties = null)
    {
        if (is_null($properties) || !isset($properties['class'])) {
            $properties = array('class' => 'form-control');
        } else {
            $properties['class'] .= ' form - control  ';
        }

        parent::__construct($name, $content, $properties);
    }

}

class EeaseTWBListGroup extends EaseHtmlUlTag
{

    /**
     * Vytvori ListGroup
     *
     * @link http://getbootstrap.com/components/#list-group ListGroup
     * @param mixed $ulContents položky seznamu
     * @param array $properties parametry tagu
     */
    public function __construct($ulContents = null, $properties = null)
    {
        parent::__construct($ulContents, $properties);
        $this->addTagClass('list-group');
    }

    /**
     * Every item id added in EaseHtmlLiTag envelope
     *
     * @param mixed  $pageItem     obsah vkládaný jako položka výčtu
     * @param string $properties   Vlastnosti LI tagu
     *
     * @return mixed
     */
    function &addItemSmart($pageItem, $properties = null)
    {
        $item = parent::addItemSmart($pageItem, $properties);
        $item->addTagClass('list-group-item');
        return $item;
    }

}
