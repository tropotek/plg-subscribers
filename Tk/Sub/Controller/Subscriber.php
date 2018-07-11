<?php
namespace Tk\Sub\Controller;

use Tk\Request;
use Tk\Form;


/**
 * @author Michael Mifsud <info@tropotek.com>
 * @link http://www.tropotek.com/
 * @license Copyright 2015 Michael Mifsud
 */
class Subscriber extends \Bs\Controller\Iface
{

    /**
     * @var Form
     */
    protected $form = null;


    /**
     * @param Request $request
     * @throws \Exception
     */
    public function doDefault(Request $request)
    {
        $this->setPageTitle('Signup For Updates');

        if ($request->getReferer()->getHost() != \Tk\Uri::create()->getHost()) {
            throw new \Tk\Exception('Unknown server error.');
        }

        if ($request->has('signup')) {
            $this->doSubmit($request);
        }


    }

    /**
     * @param Request $request
     * @throws \Tk\Db\Exception
     */
    public function doSubmit(Request $request)
    {

        $subscriber = new \App\Db\Subscriber();
        $subscriber->name = $request->get('name');
        $subscriber->email = $request->get('email');

        $valid = $subscriber->validate();
        if (count($valid)) {
            $msg = '<p>Error submitting newsletter form. Please try again: <br/>';
            foreach ($valid as $k => $v) {
                $msg .= sprintf('%s: %s<br/>', $k, $v);
            }
            $msg .= '</p>';
            \Tk\Alert::addError($msg);
            return;
        }

        $subscriber->save();
        \Tk\Alert::addSuccess('Thank you for your subscription.');
        if ($request->getReferer())
        \Tk\Uri::create()->reset()->redirect();
    }


    /**
     * @return \Dom\Template
     * @throws \Dom\Exception
     */
    public function show()
    {
        $template = parent::show();




        return $template;
    }

}