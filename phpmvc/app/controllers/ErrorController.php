<?php

class ErrorController extends Controller {
    public function accessAction()
    {
        $this->setTitle("Доступ заборонено");

        $this->setView('403');
        $this->renderLayout();
    }
}