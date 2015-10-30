<?
class NavigationWidget extends Widget
{
    public $location = 'top';
    public $template = 'index';
    
    public function run()
    {
        $criteria = new CDbCriteria();
        
        $criteria->condition = 'location=:location AND is_visible=:is_visible';
        $criteria->params = array(
            'location'=>$this->location,
            'is_visible'=>(int)TRUE,
        );
        $criteria->order = 'sort_order';

        $navigations = Navigation::model()->findAll($criteria);

        echo $this->render($this->template, array('navigations' => $navigations), true);
    }
}