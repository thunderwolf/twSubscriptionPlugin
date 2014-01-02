<?php

class sfValidatorAuthKey extends sfValidatorString
{
    protected function configure($options = array(), $messages = array())
    {
        return parent::configure($options, $messages);
    }

    public function clean($value)
    {
        if ($value == '') {
            $value = md5(microtime(true));
        }
        return parent::clean($value);
    }
}