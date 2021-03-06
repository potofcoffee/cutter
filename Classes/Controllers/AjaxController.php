<?php
/*
 * CUTTER
 * Versatile Image Cutter and Processor
 * http://github.com/VolksmissionFreudenstadt/cutter
 *
 * Copyright (c) 2015 Volksmission Freudenstadt, http://www.volksmission-freudenstadt.de
 * Author: Christoph Fischer, chris@toph.de
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace VMFDS\Cutter\Controllers;

/**
 * Description of AjaxController
 *
 * @author chris
 */
class AjaxController extends AbstractController
{
    protected $data = false;

    /**
     * Override default renderView() function
     *
     * This controller will behave as a JSON controller, which means:
     * (1) default view output will NOT happen
     * (2) Content-Type will be set to application/json
     * (3) an internal array $data will be output as JSON
     */
    public function renderView()
    {
        $this->view->setContentType('application/json');
        $this->view->sendContentTypeHeader();
        echo json_encode($this->data);
    }

    public function loadAction()
    {
        $request = \VMFDS\Cutter\Core\Request::getInstance();
        $request->applyUriPattern(array('key'));
        if ($request->hasArgument('key')) {
            $key        = $request->getArgument('key');
            $template   = \VMFDS\Cutter\Factories\TemplateFactory::get($key);
            $this->data = $template->getTemplateInfo();
        }
    }

    public function optionsAction()
    {
        $request = \VMFDS\Cutter\Core\Request::getInstance();
        $request->applyUriPattern(array('key'));
        if ($request->hasArgument('key')) {
            $key        = $request->getArgument('key');
            $template   = \VMFDS\Cutter\Factories\TemplateFactory::get($key);
            $processor  = $template->getProcessorObject();
            $processor->setOptionsArray($template->getProcessorOptions());
            $this->data = $processor->getAdditionalFields();
        }
    }
}