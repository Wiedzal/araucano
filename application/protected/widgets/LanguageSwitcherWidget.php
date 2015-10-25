<?
class LanguageSwitcherWidget extends CWidget
{
    public function run()
    {
        $currentUrl = ltrim(Yii::app()->request->url, '/');
        $links = array();
        foreach (DMultilangHelper::suffixList() as $suffix => $name){
            $alias = $suffix ? trim($suffix, '_') : 'ru';
            $url = '/' . ($suffix ? trim($suffix, '_') . '/' : '') . $currentUrl;
            $links[] = CHtml::tag('li', array('class'=>"lang-item"), CHtml::link(CHtml::image(Yii::app()->theme->baseUrl."/public/site/img/lang/".$alias.".png", $name), $url, array("class"=>"lang-link", "title"=>$alias)));
        }
        echo CHtml::tag('ul', array('class'=>'lang-list'), implode("\n", $links)); 
    }
}