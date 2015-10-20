<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function nouveauAction() {
        $aitTest = new Application_Model_DbTable_DbJtable();

        if ($this->_request->getParam("add") && ($formData = $this->_request->getPost())) {
            //Formatage des données avec zend
            $row = $aitTest->createRow();
            $row->nom = $formData["nom"];
            $row->prenom = $formData["prenom"];
            $id = $row->save();
            $rowIns = $aitTest->fetchRow(array("id = ?" => $id))->toArray();
            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $jTableResult['Record'] = $rowIns;
            $this->_helper->json($jTableResult);
        } elseif ($this->_request->getParam("up") && ($formData = $this->_request->getPost())) {
            //Formatage des données avec zend

            $row = $aitTest->fetchRow(array("id = ?" => $formData["id"]));
            $row->nom = $formData["nom"];
            $row->prenom = $formData["prenom"];
            $id = $row->save();
            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $this->_helper->json($jTableResult);
        } elseif ($this->_request->getParam("del") && ($formData = $this->_request->getPost())) {
            //Formatage des données avec zend

            $row = $aitTest->fetchRow(array("id = ?" => $formData["id"]));
            $aitTest->delete(array("id = ?" => $formData["id"]));
            //Return result to jTable
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $this->_helper->json($jTableResult);
        } else {
            //
            file_put_contents("record.txt", $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"]."\r\n", FILE_APPEND);
            $rows = $aitTest->fetchAll(NULL, $_GET["jtSorting"], $_GET["jtPageSize"], $_GET["jtStartIndex"]);
            $recordCount = $rows->count();
            //print_r();
            $jTableResult = array();
            $jTableResult['Result'] = "OK";
            $jTableResult['TotalRecordCount'] = $recordCount;
            $jTableResult['Records'] = $rows->toArray();
            $this->_helper->json($jTableResult);
        }
    }

}
