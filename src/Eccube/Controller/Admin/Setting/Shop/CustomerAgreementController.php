<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Eccube\Controller\Admin\Setting\Shop;

use Eccube\Application;
use Eccube\Controller\AbstractController;

class CustomerAgreementController extends AbstractController
{
    public $form;

    public function __construct()
    {
    }

    public function index(Application $app)
    {
        $help = $app['eccube.repository.help']->get();

        $form = $app['form.factory']
            ->createBuilder('customer_agreement', $help)
            ->getForm();

        if ($app['request']->getMethod() === 'POST') {
            $form->handleRequest($app['request']);
            if ($form->isValid()) {
                $app['orm.em']->persist($help);
                $app['orm.em']->flush();
                $app['session']->getFlashBag()->add('customer_agreement.complete', 'admin.register.complete');

                return $app->redirect($app['url_generator']->generate('admin_setting_shop_customer_agreement'));
            }
        }

        return $app['view']->render('Admin/Setting/Shop/customer_agreement.twig', array(
            'form' => $form->createView(),
        ));
    }
}