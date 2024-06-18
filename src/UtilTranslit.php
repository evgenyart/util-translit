<?php

namespace MyProject\TestUtil;

class UtilTranslit
{
    private $defaultParams;
    private $search;

    public function __construct()
    {
        $this->defaultParams = [
            'change_case' => 'L',
            'replace_space' => '_',
            'replace_other' => '_',
            'delete_repeat_replace' => true
        ];

        $translitFrom = explode(",", 'а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,ь,э,ю,я,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Ь,Э,Ю,Я');
        $translitTo = explode(",", 'a,b,v,g,d,e,ye,zh,z,i,y,k,l,m,n,o,p,r,s,t,u,f,kh,ts,ch,sh,shch,,y,,e,yu,ya,A,B,V,G,D,E,YE,ZH,Z,I,Y,K,L,M,N,O,P,R,S,T,U,F,KH,TS,CH,SH,SHCH,,Y,,E,YU,YA');

        foreach ($translitFrom as $i => $from) {
            $this->search[$from] = $translitTo[$i];
        }
    }

    public function translit($str, $params = [])
    {
        if (!empty($params)) {
            $resultCheck = $this->validateParams($params);

            if (!empty($resultCheck)) {
                print_r('Error! ' . implode(PHP_EOL, $resultCheck));
                return false;
            }

            foreach ($params as $key => $value) {
                $this->defaultParams[$key] = $value;
            }
        }

        if ($this->defaultParams['delete_repeat_replace']) {
            $str = preg_replace('|[\s]+|s', ' ', $str);
        }

        $len = mb_strlen($str);
        $strTranslit = "";

        for ($i = 0; $i < $len; $i++) {
            $chr = mb_substr($str, $i, 1);
            $chrNew = "";

            if (preg_match('/[A-Za-z0-9]/', $chr)) {
                $chrNew = $chr;
            } elseif (preg_match("/\\s/", $chr)) {
                if ($this->defaultParams['replace_space']) {
                    $chrNew = $this->defaultParams['replace_space'];
                } else {
                    $chrNew = $chr;
                }
            } elseif (array_key_exists($chr, $this->search)) {
                $chrNew = $this->search[$chr];
            } else {
                if ($this->defaultParams['replace_other']) {
                    $chrNew = $this->defaultParams['replace_other'];
                } else {
                    $chrNew = $chr;
                }
            }

            if (strlen($chrNew)) {
                if ($this->defaultParams['change_case']) {
                    if ($this->defaultParams['change_case'] == "U") {
                        $chrNew = strtoupper($chrNew);
                    } elseif ($this->defaultParams['change_case'] == "L") {
                        $chrNew = strtolower($chrNew);
                    }
                }

                $strTranslit .= $chrNew;
            }
        }

        return $strTranslit;
    }

    private function validateParams($params)
    {
        $arErrors = [];
        $changeCaseAvailable = ["L", "U", false];

        $availableParams = array_keys($this->defaultParams);

        if (!(is_array($params))) {
            return ["Parameters must be an array or empty"];
        }


        foreach ($params as $param => $value) {
            if (!in_array($param, $availableParams)) {
                $arErrors[] = 'Unknown param ' . $param . ', available params: ' . implode(',', $availableParams);
            }
        }

        if (isset($params['change_case'])) {
            if (!in_array($params['change_case'], $changeCaseAvailable)) {
                $arErrors[] = 'Param change_case should be in ' . implode(',', $changeCaseAvailable);
            }
        }

        return $arErrors;
    }
}
