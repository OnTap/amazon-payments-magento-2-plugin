<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace Amazon\Payment\Block\Cart;

//class Sidebar extends \Magento\Checkout\Block\Cart\Sidebar
class Sidebar extends \Magento\Framework\View\Element\AbstractBlock implements BlockInterface
{
    public function toHtml()
    {
        parent::toHtml();
        //die(__METHOD__);
        //$block = parent::toHtml();
        // $block->setData("componentDisabled", false);

        /*
        //$block->getChildBlock("minicart");
        //die(get_class($block));
        /*

        if($i==1){
            parent::toHtml();
        }*/
        //return $block;
    }
}
