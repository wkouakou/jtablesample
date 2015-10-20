<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initView()
    {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
        //$view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');
        $view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        //jQuery
        $view->jQuery()->setLocalPath('/jtables/scripts/jquery-1.9.1.js')
                ->setUiLocalPath('/jtables/scripts/jquery-ui-1.10.1.custom.js')
                ->addStyleSheet('/jtables/css/jquery-ui-1.10.1.custom.css');
        
        $view->headLink()//->appendStylesheet('/jtables/themes/redmond/jquery-ui-1.8.16.custom.css')
                ->appendStylesheet('/jtables/scripts/jtable/themes/lightcolor/blue/jtable.css')
                ->appendStylesheet('/jtables/css/bootstrap.css')
                ->appendStylesheet('/jtables/css/bootstrap-theme.css');
        //Script
        $view->headScript()
                ->appendFile('/jtables/scripts/jquery-1.6.4.min.js')
                ->appendFile('/jtables/scripts/jquery-ui-1.8.16.custom.min.js')
                ->appendFile('/jtables/scripts/jtable/jquery.jtable.min.js')
                ->appendFile('/jtables/scripts/jtable/localization/jquery.jtable.fr.js');
                //->appendFile('/jtables/scripts/bootstrap.js');
        
        //Zend_Dojo::enableView($view);
        Zend_Paginator::setDefaultScrollingStyle('Elastic');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('partials/pagination.phtml');

        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        //seulement si on utilise d'autres frameworks ajax
        ZendX_JQuery_View_Helper_JQuery::enableNoConflictMode();

        
        return $view;
    }

}
