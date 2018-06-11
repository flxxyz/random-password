<?php

namespace RandomPassword;


class Password
{

    private $count = 1;

    private $length = 8;

    private $ucfirst = false;

    private $ignore = [];

    private $symbols
        = [
            'lower_case'      => 'abcdefghijklmnopqrstuvwxyz',
            'upper_case'      => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'number'          => '1234567890',
            'special_symbols' => '~!@#$%^&*()_+{}|:<>?`[]\\;,./',
        ];

    private $used_symbols = '';

    private $passwords = [];

    public function __construct($count = 1, $length = 8)
    {
        $this->count(func_get_args()[0] ?? $this->count);
        $this->length(func_get_args()[1] ?? $this->length);
    }

    /**
     * set the number of generation
     *
     * @param $count
     *
     * @return $this
     */
    public function count($count)
    {
        if ($this->count <=> $count) {
            $this->count = $count;
        }

        return $this;
    }

    /**
     * set the generated length
     *
     * @param $length
     *
     * @return $this
     */
    public function length($length)
    {
        if ($this->length <=> $length) {
            $this->length = $length;
        }

        return $this;
    }

    /**
     * ignoring some symbols
     *
     * @param string $name
     *
     * @return $this
     */
    public function ignore($name = '')
    {
        $flag = true;
        foreach ($this->ignore as $item) {
            if ($item == $name) {
                $flag = false;
            }
        }

        if ($flag) {
            $this->ignore[] = $name;
        }

        return $this;
    }

    /**
     * restore to default string
     */
    private function clear()
    {
        $this->count(8);
        $this->length(8);
        $this->ucfirst = false;
        $this->ignore = [];
    }

    /**
     * start the engine
     *
     * @return mixed
     */
    public function generate()
    {
        foreach ($this->symbols as $n => $v) {
            if (in_array($n, $this->ignore)) {
                continue;
            }
            $this->used_symbols .= $v;
        }

        $length = mb_strlen($this->used_symbols) - 1;

        for ($p = 0; $p < $this->count; $p++) {
            $pass = '';
            for ($i = 0; $i < $this->length; $i++) {
                if ($this->ucfirst) {
                    if ($i === 0) {
                        $pass .= $this->symbols['upper_case'][mt_rand(0,
                            mb_strlen($this->symbols['upper_case']) - 1)];
                        continue;
                    }
                }

                $pass .= $this->used_symbols[mt_rand(0, $length)];
            }

            $this->passwords[] = $pass;
        }

        $this->clear();

        return $this->password();
    }

    /**
     * 首字母大写且为英文字符
     * @param bool $ucfirst
     *
     * @return $this
     */
    public function ucfirst(bool $ucfirst = true)
    {
        $this->ucfirst = $ucfirst;

        return $this;
    }

    /**
     * @return array
     */
    public function passwords()
    {
        return $this->passwords;
    }

    /**
     * @return mixed
     */
    public function password()
    {
        return $this->passwords[count($this->passwords) - 1];
    }

}