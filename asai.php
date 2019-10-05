<?php
//-----------------------------------main

global $conn, $connty,$output;
global $g_sqln, $g_lin, $g_ltf, $g_lrr, $g_lii, $g_lco;
$g_sqln = 0;
$g_lin = '0';//临时变量
$g_ltf = false;//临时变量
$output=array();

//-----------------------------------
//read url
//-----------------------------------
global $g_uwww, $g_ur, $g_url, $g_urr, $g_u0, $g_u1, $g_u2, $g_u3, $g_u4, $g_u5, $g_u6;
$g_u1=null;
//$g_uwww=$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"];//包含端口号的完整url
$g_uwww = $_SERVER['HTTP_HOST'];
$g_ur = "http://" . $g_uwww . str_ireplace("index.php", "", $_SERVER['PHP_SELF']);
if (substr($g_ur, -1) <> "/" && substr($g_ur, -3) <> "php") {
    $g_ur = $g_ur . "/";
}
$g_url = $g_ur;
$g_urs = $_SERVER["QUERY_STRING"];
if ($g_urs <> "") {
    $g_url = $g_url . "?" . $g_urs;
    $g_urr = explode('/', str_ireplace('.json', '', str_ireplace('.html', '', $g_urs)) . '////////');
    $g_u0 = $g_urr[0];
    $g_u1 = $g_urr[1];
    $g_u2 = $g_urr[2];
    $g_u3 = $g_urr[3];
    $g_u4 = $g_urr[4];
    $g_u5 = $g_urr[5];
    $g_u6 = $g_urr[6];
};
//echo '$g_url='.$g_url.'<br>$g_uwww='.$g_uwww.'<br>$g_ur='.$g_ur.'<br>$g_urs='.$g_urs.'<br>$g_u0='.$g_u0.'<br>$g_u1='.$g_u1.'<br>$g_u2='.$g_u2.'<br>$g_u3='.$g_u3.'<br>$g_u4='.$g_u4.'<br>$g_u5='.$g_u5.'<br>$g_u6='.$g_u6;

//---------------------------
// aierr(0, "这是一个数据存取的错误提示！");
// aierr(1, "这是一个普通调试信息！");
// aierr(2, "这是一个管理级别的错误提示！");
// aierr(0, "这是一个数据存取的错误提示（第二次）！");
//---------------------------
function aierr($aifty, $aifstr)
{
    if (G_ERR > 0) {
        if ($aifty == 1) {
            aifwt(G_ERRL, microtime() . "：" . $aifstr . "\r\n");
        } elseif ($aifty == 2) {
            if (G_ERR > 1) {
                aifwt(G_ERRL, microtime() . "：" . $aifstr . "\r\n");
            }
        } else {
            $GLOBALS['g_sqln'] += 1;
            aifwt(G_ERRL, $GLOBALS['g_sqln'] . "、".microtime()."：".$aifstr."\r\n");
        }
    }
}

//-----------------------------------
//print_r(aifck('1.txt'));
//print_r(aifck('http://asai.wang/asai.html'));
//-----------------------------------
function aifck($aifdir)
{
    if (strpos($aifdir, "://") > 0) {
        // 屏蔽域名不存在等访问问题的警告
        error_reporting(E_ALL ^ (E_WARNING | E_NOTICE));
        $header = get_headers($aifdir, true);
        $GLOBALS['g_ltf'] = isset($header[0]) && (strpos($header[0], '200') || strpos($header[0], '304'));
        if ($GLOBALS['g_ltf']) {
            $GLOBALS['g_lin'] = '4';
        } else {
            $GLOBALS['g_lin'] = '3';
        }
        return $GLOBALS['g_ltf'];
    } else {
        if (file_exists($aifdir) or is_dir($aifdir)) {
            $GLOBALS['g_lin'] = '2';
            return true;
        } else {
            $GLOBALS['g_lin'] = '1';
            return false;
        }
    }
}

//---------------------------
//echo aifrd("1.txt");
//echo aifrd("http://asai.wang/asai.html");
//---------------------------
function aifrd($aifdir)
{
    $GLOBALS['g_lin'] = '0';
    if (aifck($aifdir)) {
        $aidty = $GLOBALS['g_lin'];
        if ($aidty == '4') {
            $aidch = curl_init();
            curl_setopt($aidch, CURLOPT_URL, $aifdir);
            curl_setopt($aidch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($aidch, CURLOPT_CONNECTTIMEOUT, 10);
            $aidur = curl_exec($aidch);
        } elseif ($aidty == '2') {
            $aidur = readfile($aifdir);
        //$aidur=file_get_contents($aifdir);
        } else {
            $aidur = '';
        }
        return $aidur;
    }
}

//---------------------------
//print_r(aifwr('asai.txt','写了一个asai文件！'));
//print_r(aifwr('asai/wang/asai.html',aifrd("http://asai.wang/asai.html")));
//---------------------------
function aifwr($aifdir, $aifstr)
{
    if (ainullx($aifdir, '')) {
        return false;
    } else {
        aifcd(dirname($aifdir));
        file_put_contents($aifdir, $aifstr);
        return true;
    }
}

//---------------------------
//print_r(aifwt('asai.txt','向asai文件增加内容！'));
//print_r(aifwt('asai/wang/asai.html',aifrd("http://asai.wang/asai.html")));
//---------------------------
function aifwt($aifdir, $aifstr)
{
    if (ainullx($aifdir, '')) {
        return false;
    } else {
        aifcd(dirname($aifdir));
        file_put_contents($aifdir, $aifstr, FILE_APPEND);
        // fwrite(fopen($aifdir,'ab+'),$aifstr);//另一种方法
        return true;
    }
}

function aifcd($aifdir)
{
    return is_dir($aifdir) or (aifcd(dirname($aifdir)) and mkdir($aifdir, 0777));
}

//---------------------------
//print_r aihpj("http://www.909.pub/", "?asai/show/123/");
//---------------------------
function aihpj($aifurl, $aifstr)
{
    $aifurl = $aifurl . $aifstr;
    if (($ch = curl_init($aifurl)) == false) {
        throw new Exception(sprintf()("curl_init error for url %s.", $aifurl));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    if (is_array($aifstr)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data;'));
    }
    $postResult = @curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($postResult === false || $http_code != 200 || curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("HTTP POST FAILED:$error");
    } else {
        // $postResult=str_replace()("\xEF\xBB\xBF", '', $postResult);
        switch (curl_getinfo($ch, CURLINFO_CONTENT_TYPE)) {
            case 'application/json':
                $postResult = json_decode()($postResult);
                break;
        }
        curl_close($ch);
        return $postResult;
    }
}

//-----------------------------------
//print_r(ainullx($g_u1,'0'));
//-----------------------------------
function ainullx($aifstr, $aifsmx)
{
    if (empty($aifstr) or strcasecmp($aifstr, $aifsmx) == 0) {
        return true;
    } else {
        return false;
    }
}

//---------------------------
//echo aiint("123asai|88");
//---------------------------
function aiint($aifstr)
{
    $aidnrr = explode('|', $aifstr . '|0');
    $aidnx = $aidnrr[0];
    if (!is_numeric($aidnx)) {
        $aidnx = $aidnrr[1];
        if (strcasecmp($aidnx, 'x') == 0) {
            $aidnx = $aidnrr[0];
        }
    }
    $aidnx = intval($aidnx);
    return $aidnx;
}

//---------------------------
//echo aitm(8,'20190122122858');
//echo aitm(2,date("Y-m-d H:i:s"));
//echo aitm(5,date("Y-m-d H:i:s"));
//---------------------------
function aitm($aifty, $aifstr)
{
    if ($aifty == 8) {
        $aitlin = strlen($aifstr);
        if ($aitlin > 3) {
            $aitm = substr($aifstr, 0, 4) . "年";
        }
        if ($aitlin > 5) {
            $aitm .= substr($aifstr, 4, 2) . "月";
        }
        if ($aitlin > 7) {
            $aitm .= substr($aifstr, 6, 2) . "日";
        }
        if ($aitlin > 9) {
            $aitm .= substr($aifstr, 8, 2) . "时";
        }
        if ($aitlin > 11) {
            $aitm .= substr($aifstr, 10, 2) . "分";
        }
        if ($aitlin > 13) {
            $aitm .= substr($aifstr, 12, 2) . "秒";
        }
    } else {
        $is_date = strtotime($aifstr) ? strtotime($aifstr) : false;
        if ($is_date === false) {
            $aifstr = date("Y-m-d H:i:s");
        }
        $aifstr = strtotime($aifstr);
        $aitm = date("Y", $aifstr);
        if ($aifty > 0) {
            $aitm .= date("m", $aifstr);
        }
        if ($aifty > 1) {
            $aitm .= date("d", $aifstr);
        }
        if ($aifty > 2) {
            $aitm .= date("H", $aifstr);
        }
        if ($aifty > 3) {
            $aitm .= date("i", $aifstr);
        }
        if ($aifty > 4) {
            $aitm .= date("s", $aifstr);
        }
        $aitm = aiint($aitm);
    }
    return $aitm;
}

//---------------------------
//echo aixn("123456789",0).'<br>';
//echo aixn("21I3V9",1).'<br>';
//echo aixn(aixn("147258369",0),1);
//---------------------------
function aixn($aifstr, $aifty)
{
    $aidnrr = explode('|', '0|1|2|3|4|5|6|7|8|9|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z');
    if ($aifty == 0) {
        $aixn = '';
        $aidnl = intval($aifstr);
        if ($aidnl < 36) {
            $aixn = $aidnrr[$aidnl];
        } else {
            $aidnlz = intval($aidnl / 36);
            $aidnly = $aidnrr[$aidnl % 36];
            $aixnl = $aidnly;
            while ($aidnlz > 35) {
                $aidnl = $aidnlz;
                $aidnlz = intval($aidnl / 36);
                $aidnly = $aidnrr[$aidnl % 36];
                $aixn = $aidnly . $aixn;
            }
            $aixn = $aidnrr[$aidnlz] . $aixn . $aixnl;
        }
    } else {
        $aixn = 0;
        $aixnl = 0;
        $aidnx = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $aidnlen = strlen($aifstr);
        if ($aidnlen == 1) {
            $aixn = strpos($aidnx, $aifstr);
        } else {
            $aifstr = strrev($aifstr);
            for ($aidni = 1; $aidni <= $aidnlen; $aidni++) {
                $aixn += strpos($aidnx, substr($aifstr, ($aidni - 1), 1)) * pow(36, ($aidni - 1));
            }
        }
    }
    return $aixn;
}

//---------------------------
//echo aisn(1);
//echo aisn(2).'<br>'.aisn(2).'<br>'.aisn(2).'<br>'.aisn(2).'<br>';
//echo aisn(0);
//---------------------------
function aisn($aifty)
{
    if ($aifty == 0) {
        setcookie("aisn", "", time() - 3600);
    } elseif ($aifty == 1 && $_COOKIE["aisn"] <> '') {
        $aisn = $_COOKIE["aisn"];
    } else {
        $aisn = aixn(aitm(5, date("Y-m-d H:i:s")) . mt_rand(0, 9), 0);
        if ($aifty == 1) {
            setcookie("aisn", $aisn, time() + 360000);
        }
    }
    return $aisn;
}

//-----------------------------------
//echo aiip();
//-----------------------------------
function aiip()
{
    $aiip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $aiip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $aiips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($aiip) {
            array_unshift($aiips, $aiip);
            $aiip = false;
        }
        for ($aiipi = 0; $aiipi < count($aiips); $aiipi++) {
            if (!eregi("^(10│172.16│192.168).", $aiips[$aiipi])) {
                $aiip = $aiips[$aiipi];
                break;
            }
        }
    }
    return ($aiip ? $aiip : $_SERVER['REMOTE_ADDR']);
}

//-----------------------------------
//echo aiipr();
//-----------------------------------
function aiipr()
{
    return aifrd('http://ip.780.pub/?ty=7&ip=' . aiip());
}

//-----------------------------------
//echo aijia("http://www.asai.wang/?name=阿赛工作室asai.wang")."<br>";
//echo aijie("http://www.asai.wang/?name=-As963f-As8d5b-As5de5-As4f5c-As5ba4asai.wang");
//-----------------------------------
function aijia($aifstr)
{
    $aifstr = iconv('UTF-8', 'UCS-2', $aifstr);
    $len = strlen($aifstr);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2) {
        $c = $aifstr[$i];
        $c2 = $aifstr[$i + 1];
        if (ord($c) > 0) {   //两个字节的文字
            $str .= '-As' . base_convert(ord($c), 10, 16) . str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
        } else {
            $str .= $c2;
        }
    }
    return $str;
}

function aijie($aifstr)
{
    $aifstr = str_replace('-As', '\\u', $aifstr);
    $json = '{"str":"' . $aifstr . '"}';
    $arr = json_decode($json, true);
    if (empty($arr)) {
        return '';
    }
    return $arr['str'];
}

//-----------------------------------
//echo aimm(G_GMM,"!http://www.asai.wang/?name=阿赛工作室asai.wang",0)."<br>";
//echo aimm(G_GMM,'!wtRu://aEwD~0BFMjxXg/?T@OR.PrKs7NBcfESjXcC1B=2f9Alp~1EJQgY~pX2PZT~G=97d',1);
//-----------------------------------
function aimm($aifkey, $aifstr, $aifty)
{
    $aimm = '';
    $aiklen = strlen($aifkey);
    if ($aifty == 0) {
        $aifstr = aijia($aifstr);
    }
    $aidlen = strlen($aifstr);
    $aikdys = $aidlen % $aiklen;
    $aidks = strrev(substr($aifkey, $aikdys, $aiklen) . substr($aifkey, 0, $aikdys));
    $aidks = $aidks . $aidks;
    for ($aidni = 1; $aidni <= $aidlen; $aidni++) {
        $aidsy = substr($aifstr, ($aidni - 1), 1);
        $aidnw = strpos($aifkey, $aidsy);
        if ($aidnw !== false) {
            if ($aifty == 0) {
                $aimm .= substr($aidks, ($aidnw + ($aidni % $aiklen)), 1);
            } else {
                $aimm .= substr($aidks, ($aidnw + ($aidni % $aiklen)), 1);
            }
        } else {
            $aimm .= $aidsy;
        }
    }
    if ($aifty == 1) {
        $aimm = aijie($aimm);
    }
    return $aimm;
}

//---------------------------
//echo aireq("ty");
//---------------------------
function aireq($aifnm)
{
    if ($aifnm <> '') {
        //$aireq="";
        $aireq = !empty($_REQUEST[$aifnm]) ? $_REQUEST[$aifnm] : null;
        if (ainullx($aireq, '')) {
            $aireq = !empty($_POST[$aifnm]) ? $_POST[$aifnm] : null;
        };
        if (ainullx($aireq, '')) {
            $aireq = !empty($_GET[$aifnm]) ? $_GET[$aifnm] : null;
        };
        if (gettype($aireq) == "array") {
            $airdls = "";
            foreach ($aireq as $airdv) {
                $airdls .= htmlentities(trim($airdv), ENT_QUOTES) . ", ";
            }
            $aireq = $airdls;
        }
    }
    //if(!ainullx($aireq,'')){$aireq=lib_replace_end_tag($aireq);};//防注入
    return $aireq;
}

//---------------------------
//print_r(aireqr("ai_id,ai_bt,ai_fl,ai_nr","ai_"));
//echo $ai_id.'/'.$ai_bt.'/'.$ai_fl.'/'.$ai_nr;
//---------------------------
function aireqr($aiflie, $aiflq)
{
    $ardrr = explode(",", $aiflie);
    $ardco = count($ardrr);
    if ($ardco > 0) {
        for ($ardii = 0; $ardii < $ardco; $ardii++) {
            $ardlie = $ardrr[$ardii];
            global $$ardlie;
            $ardrfs = str_replace($aiflq, "", $ardlie);
            $ardlin = aireq($ardrfs);
            $$ardlie = $ardlin;
        }
        return true;
    } else {
        return false;
    }
}

//---------------------------
//$azifu="阿赛工作室<!---这是注释文字--->asai.wang>02590.com>eesai<img src='http://www.baidu.com/logo.gif'>好看的<p>设计</p>美工<br>。一大批                                  空格！\n";
//echo aistr(0,$azifu).'\n';
//echo aistr(1,$azifu).'\n';
//echo aistr(2,$azifu).'\n';
//---------------------------
function aistr($aifty, $aifstr)
{
    if ($aifty == 0) {
        return strip_tags($aifstr, '<img><p><br>');
    } elseif ($aifty == 1) {
        return strip_tags($aifstr);
    } elseif ($aifty == 2) {
        $aifstr = strip_tags($aifstr);
        $aifstr = preg_replace("/[\s]+/is", " ", $aifstr);
        $search = array("\n", "\r", "\t");
        $replace = array("", "", "");
        return str_replace($search, $replace, $aifstr);
    }
}

//---------------------------
//if (aiconn(realpath("asai.mdb"))){echo 'PDO连接成功！';}else{echo G_COBB;}//access
//if (aiconn(realpath("asai.mdb"),"asaipass")){echo 'PDO连接成功！';}else{echo G_COBB;}//access+password
//if (aiconn('mysql:host=localhost;dbname=t_api,root,root')){echo 'PDO连接成功！';}else{echo G_COBB;}//mysql
//if (aiconn('localhost:1433,t_api,sa,sa123')){echo 'PDO连接成功！';}else{echo G_COBB;}//mssql
//aiconn(0);
//---------------------------
function aiconn($aifstr)
{
    if ($aifstr === 0) {
        $GLOBALS['conn'] = null;
    } else {
        // aierr(2, $aifstr);
        try {
            $aidcrr = explode(',', $aifstr . '');
            $GLOBALS['connty'] = count($aidcrr);
            if ($GLOBALS['connty'] == 1) {
                $GLOBALS['conn'] = new PDO("odbc:driver={microsoft access driver (*.mdb)};dbq=" . $aidcrr[0] . ";", "", "", array(PDO::ATTR_PERSISTENT=>true,PDO::ATTR_ERRMODE=>2,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
            //echo $GLOBALS['conn'];
                                //array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names GB2312")//array(PDO::ATTR_PERSISTENT=>true,PDO::ATTR_ERRMODE=>2,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8')
                //$GLOBALS['conn']->query("SET NAMES UTF8");
                //$GLOBALS['conn']->exec("SET NAMES UTF8");
            } elseif ($GLOBALS['connty'] == 2) {
                $GLOBALS['conn'] = new PDO("odbc:driver={microsoft access driver (*.mdb)};dbq=" . $aidcrr[0] . ";pwd=" . $aidcrr[1]);
            } elseif ($GLOBALS['connty'] == 4) {
                $GLOBALS['conn'] = new PDO("dblib:host=" . $aidcrr[0] . ";dbname=" . $aidcrr[1] . ";charset=UTF8;", $aidcrr[2], $aidcrr[3]);
            } elseif ($GLOBALS['connty'] == 3) {
                $GLOBALS['connty'] = 9;
                $GLOBALS['conn'] = new PDO($aidcrr[0], $aidcrr[1], $aidcrr[2]);
                // 设置 PDO 错误模式，用于抛出异常
//$GLOBALS['conn']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\
            }
            return true;
        } catch (PDOException $e) {
            return false;
            aierr(2, $e->getMessage());
        }
    }
}

//---------------------------
//gysjia
//---------------------------
function gysjia($aifarr)
{
    return base64_encode($aifarr);
}
//---------------------------
//gysjie
//---------------------------
function gysjie($aifarr)
{
    $aifarr=json_decode(base64_decode($aifarr), true);
    $aifarr=json_decode(json_encode($aifarr), true);
    //echo '<h1>类型是：'.gettype($aifarr).'</h1>';
    return $aifarr;
}
//---------------------------
//saipost
//---------------------------
function saipost()
{
    // aifwr('asai.json',gysjia(file_get_contents('php://input')));
    // aifwr('asaix.json',gysjie(gysjia(file_get_contents('php://input'))));
    return gysjia(file_get_contents('php://input'));
    //aifwr('asai.json',file_get_contents('php://input'));
    //return file_get_contents('php://input');
      //echo '111111111111'.gettype(file_get_contents('php://input'));
    //return json_decode(file_get_contents('php://input'), true);
}

//---------------------------
//$gyskt 強制发布=0|编辑=查询条件,存在就更新 不存在就添加
//if (aiconn(G_CONN)){
//print_r(saido("asai_uj","uj_ty,uj_us,uj_co,uj_tm", saipost(),0));
//print_r(saido("asai_uj","uj_ty,uj_us,uj_co,uj_tm", saipost(),"uj_id=10"));
//print_r(saido("asai_uj","uj_ty,uj_us,uj_co,uj_tm", saipost()," uj_id=10"));//空格開頭的全部匹配更新
//}else{echo G_COBB;}
//aiconn(0);
//---------------------------
function saido($gyskb, $gyskl, $gysrr, $gyskt)
{
    try {
        $gyskb=G_Q.$gyskb;
        $gysrr=gysjie($gysrr);
        //echo gettype($gysrr);
        //print_r($gysrr);
        if (is_array($gysrr)) {
            foreach ($gysrr as $key => $value) {
							// aierr(2,$key.'='.$value.'='.sai2gb($value).'\r\n');
                $$key = sai2gb($value);
                // $$key = $value;
            }

            $gysklrr = explode(",", $gyskl);
            $gysklu = count($gysklrr);

            if ($gyskt == '0' || $gyskt == '') {
                $gyspr = 0;
            } else {
                $sql = "SELECT * FROM " . $gyskb . " WHERE " . $gyskt . "";
                if ($GLOBALS['connty'] > 8) {
                    $sql .= " LIMIT 1";
                }
                aierr(3, $sql);
                $gyspr = count($GLOBALS['conn']->query($sql)->fetchAll());
                //$gyspr = $GLOBALS['conn']->query($sql)->fetch()[0];
								// aierr(2, $gyspr.'---'.substr($gyskt, 0, 1));
                if ($gyspr < 1) {
                    $gyspr = 0;
                }
            }

            if ($gyspr == 0) {//添加
                $sql = "INSERT INTO " . $gyskb . " (" . $gyskl . ") VALUES (:" . str_replace(",", ",:", $gyskl) . ")";
                aierr(3, $sql);
                $stmt = $GLOBALS['conn']->prepare($sql);
                for ($gyskli = 0; $gyskli < $gysklu; $gyskli++) {
                    $gysdlm = $gysklrr[$gyskli];
                    $gysdlie = ':' . $gysdlm;
                    $gysdlin = $$gysdlm;
                    if (!empty($gysdlin)) {
                        aierr(1, $gysdlie . "===" . $gysdlin);
                        $stmt->bindValue($gysdlie, $gysdlin);
                    }
										// aierr(2,$gysdlie . '===' . $gysdlin.'\r\n');
                }
                $stmt->execute();
                //echo gettype($gysrr).'<br>'.count($gysrr);
                //print_r $gysrr;
                return $gysrr;
            //return $sql;
            } elseif ($gyspr ==1 || substr($gyskt, 0, 1)==' ') {//编辑
                $sql = "UPDATE " . $gyskb . " SET " . str_replace(",", "=?,", $gyskl) . "=? WHERE " . $gyskt . "";
                aierr(3, $sql);
                $stmt = $GLOBALS['conn']->prepare($sql);
                for ($gyskli = 0; $gyskli < $gysklu; $gyskli++) {
                    $gysdlm = $gysklrr[$gyskli];
                    $gysdlrr[$gyskli] = $$gysdlm;
										aierr(2,$gysdlrr[$gyskli] . '=' . $$gysdlm.'\r\n');
                }
                $stmt->execute($gysdlrr);
                return $gysrr;
            } else {
                return '1'.G_NULL;
            }
        } else {
            return '2'.G_NULL;
        }
    } catch (PDOExcetption $e) {
        return '3'.G_NULL;
    }
}

//---------------------------
//if (aiconn(G_CONN)){
//print(saidel("asai_uj","uj_id=8"));
//}else{echo G_COBB;}
//aiconn(0);
//---------------------------
function saidel($gyskb, $gyskt)
{
    try {
        $gyskb=G_Q.$gyskb;
        $sql = "DELETE FROM " . $gyskb;
        if ($gyskt <> '') {
            $sql .= " where " . $gyskt . "";
        }
        aierr(3, $sql);
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            return $num;
        } else {
            return G_NULL;
        }
    } catch (PDOExcetption $e) {
        return G_NULL;
    }
}

//---------------------------
//if (aiconn(G_CONN)){
//print_r(saiview("asai_uj","uj_id,uj_ty,uj_us,uj_co,uj_tm","uj_us='asai'"));
//}else{echo G_COBB;}
//aiconn(0);
//---------------------------
function saiview($gyskb, $gyskl, $gyskt)
{
    try {
        $gyskb=G_Q.$gyskb;
        $sql = "SELECT ";
        if ($GLOBALS['connty'] < 8) {
            $sql .= "top 1 ";
        }
        $sql .= $gyskl . " FROM " . $gyskb . "";
        // echo $sql;
        if ($gyskt <> '') {
            $sql .= " where " . $gyskt . "";
        }
        if ($GLOBALS['connty'] > 8) {
            $sql .= " LIMIT 1";
        }
        aierr(3, $sql);
        //$stmt = $GLOBALS['conn']->prepare($sql,"set names utf8");
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        $saiarr = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($saiarr)) {
            //print_r($saiarr);
            return $saiarr;
        } else {
            return G_NULL;
        }
    } catch (PDOExcetption $e) {
        return G_NULL;
    }
}

//---------------------------
//if (aiconn(G_CONN)){
//print_r(saitop("asai_uj","uj_id,uj_ty,uj_us,uj_co,uj_tm","uj_us='asai'","uj_id desc",5));
//}else{echo G_COBB;}
//aiconn(0);
//---------------------------
function saitop($gyskb, $gyskl, $gyskt, $gyskp, $gyskn)
{
    try {
        $gyskb=G_Q.$gyskb;
        $sql = "SELECT ";
        if ($GLOBALS['connty'] < 8) {
            if ($gyskn > 0) {
                $sql .= " top " . $gyskn . " ";
            }
        }
        $sql .= $gyskl . " FROM " . $gyskb . "";
        if ($gyskt <> '') {
            $sql .= " WHERE " . $gyskt . "";
        }
        if ($gyskp <> '') {
            $sql .= " ORDER BY " . $gyskp . "";
        }
        if ($GLOBALS['connty'] > 8) {
            if ($gyskn > 0) {
                $sql .= " LIMIT 0," . $gyskn;
            }
        }
        aierr(3, $sql);
        $stmt = $GLOBALS['conn']->prepare($sql);
        $stmt->execute();
        $saiarr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (is_array($saiarr)) {
            //print_r($saiarr);
            return $saiarr;
        } else {
            return G_NULL;
        }
    } catch (PDOExcetption $e) {
        return G_NULL;
    }
}

//---------------------------
//if (aiconn(G_CONN)){
//print_r(sailist("asai_uj","uj_id","uj_id,uj_ty,uj_us,uj_co,uj_tm","uj_us='asai'","uj_id desc",$g_u0,$g_u1));
//}else{echo G_COBB;}
//aiconn(0);
//---------------------------
function sailist($gyskb, $gyskid, $gyskl, $gyskt, $gyskp, $gyskpg, $gyskps)
{
    try {
        $gyskb=G_Q.$gyskb;
        //global $gyspg, $gysps, $gyspr, $gyspz;
        $sql = "SELECT COUNT('" . $gyskid . "') FROM " . $gyskb . "";
        if ($gyskt <> '') {
            $sql .= " WHERE " . $gyskt . "";
        }
        aierr(3, $sql);
        $gyspr = $GLOBALS['conn']->query($sql)->fetchColumn();
        $gysps = aiint($gyskps);
        if ($gysps < 1) {
            $gysps = G_PGS;
        }
        $gyspz = ceil($gyspr / $gysps);
        $gyspg = aiint($gyskpg);
        if ($gyspg < 1) {
            $gyspg = 1;
        } elseif ($gyspg > $gyspz) {
            $gyspg = $gyspz;
        }
        $sql = "SELECT ";
        if ($GLOBALS['connty'] < 8) {
            $sql .= " top " . $gysps . " ";
        }
        $sql .= $gyskl . " FROM " . $gyskb . "";

        if ($GLOBALS['connty'] < 8) {
            if ($gyspg>1) {
                if ($gyskt <> '') {
                    $sql .= " WHERE (" . $gyskt . ") and " . $gyskid . " not in (SELECT top " . ($gyspg - 1) * $gysps . " " . $gyskid . " FROM " . $gyskb . " WHERE " . $gyskt . "";
                    if ($gyskp <> '') {
                        $sql .= " ORDER BY " . $gyskp . "";
                    }
                    $sql .= ")";
                } else {
                    $sql .= " WHERE " . $gyskid . " not in (SELECT top " . ($gyspg - 1) * $gysps . " " . $gyskid . " FROM " . $gyskb . "";
                    if ($gyskp <> '') {
                        $sql .= " ORDER BY " . $gyskp . "";
                    }
                    $sql .= ")";
                }
            } else {
                if ($gyskt <> '') {
                    $sql .= " WHERE " . $gyskid . "";
                }
            }
        } else {
            if ($gyskt <> '') {
                $sql .= " WHERE " . $gyskt . "";
            }
        }
        if ($gyskp <> '') {
            $sql .= " ORDER BY " . $gyskp . "";
        }
        if ($GLOBALS['connty'] > 8) {
            $sql .= " LIMIT " . ($gyspg - 1) * $gysps . "," . $gysps;
        }
        aierr(3, $sql);
        $saiarr = $GLOBALS['conn']->query($sql)->fetchAll();
        if (is_array($saiarr)) {
            //print_r($saiarr);
            $gyspgarr = array('page' => $gyspg, 'pagesize' => $gysps, 'pagecount' => $gyspz, 'record' => $gyspr);
            //print_r($gyspgarr);
            $saiarr = array('list' => $saiarr, 'page' => $gyspgarr);
            //print_r($saiarr);
            return $saiarr;
        } else {
            return G_NULL;
        }
    } catch (PDOExcetption $e) {
        return G_NULL;
    }
}

//---------------------------
//saiout
//---------------------------
function saiout($aifty, $aifnm, $aifarr)
{
    if (is_array($aifarr)) {
        //print_r($aifarr);
        $newsaifrr=array(
            'stats' => $aifty,
            'message' => "success",
            'data' => array($aifnm => saijie($aifarr))
        );
    } else {
        $newsaifrr=array(
            'stats' => $aifty + 1,
            'message' => "none",
            'data' => array($aifnm => $aifarr)
        );
    }
    //print_r($newsaifrr);
    //return gysjia($newsaifrr);
    return $newsaifrr;
}
//---------------------------
//sai2gb
//---------------------------
function sai2gb($aifstr)
{
    if ($aifstr!=='' && $aifstr!==null) {
        $encode = mb_detect_encoding($aifstr, array('ASCII','GB2312','GBK','UTF-8'));
        echo $encode.'='.$aifstr.'=';
        //if ($encode !== "GB2312"){
        $aifstr=iconv($encode, 'GB2312//IGNORE', $aifstr);
        $aifstr=iconv('GB2312', 'GB2312//IGNORE', $aifstr);
    //$aifstr=mb_convert_encoding($aifstr,'EUC-CN',$encode);
                //}
    } else {
        $aifstr='';
    }
    echo mb_detect_encoding($aifstr, array('ASCII','GB2312','GBK','UTF-8')).'='.$aifstr.'<br>';
    return $aifstr;
}

//---------------------------
//sai2utf
//---------------------------
function sai2utf($aifstr)
{
    if ($aifstr!=='' && $aifstr!==null) {
        //$encode = mb_detect_encoding($aifstr, mb_detect_order());
        $encode = mb_detect_encoding($aifstr, array('ASCII','GB2312','GBK','UTF-8'));
        //echo $encode.'test';
        //if ($encode !== "UTF-8"){
        //echo iconv($encode, "UTF-8//TRANSLIT", $aifstr);
        $aifstr=iconv($encode, 'UTF-8//IGNORE', $aifstr);
        $aifstr=iconv('UTF-8', 'UTF-8//IGNORE', $aifstr);
    //$aifstr=mb_convert_encoding($aifstr,'UTF-8',$encode);
                //}
    } else {
        $aifstr='';
    }
    return $aifstr;
}
//---------------------------
//saijie
//---------------------------
function saijie($aifrr)
{
    $newsaifrr = array();
    $newvalueold=null;
    if (is_array($aifrr)) {
        foreach ($aifrr as $key => $val) {
            if (is_array($val)) {
                $newsaifrr[$key] = saijie($val);
            } else {
                $newvalue=sai2utf($val);
                if ($newvalueold!==$newvalue) {
                    $newsaifrr[$key] = $newvalue;
                };
                $newvalueold=$newvalue;
            }
        }
    } else {
        $newsaifrr['err'] = $aifrr;
    }
    //print_r($newsaifrr);
    return $newsaifrr;
}


//-----------------------------------email

//-----------------------------------
//define ("ASAIMAIL","eesaicom@126.com");//系统邮件，收件人需要将该邮件设为白名单，以免发件被当做垃圾件丢失。
//阿赛PHP在线发送邮件系统
//if (aiemail("4941172@qq.com","来自阿赛工作室的邮件","欢迎您回访阿赛工作室www.asai.wang，祝福您生活愉快！")){echo '发送成功！';}else{echo '发送失败！';}
//-----------------------------------
function aiemail($aifem, $aifbt, $aifnr)
{
    if (strpos($aifem, '@') > 0 and strpos($aifem, '.') > 0 and $aifbt <> '' and $aifnr <> '') {
        //使用126邮箱服务器
        $smtpserver = "smtp.126.com";
        //126邮箱服务器端口
        $smtpserverport = 25;
        //你的126服务器邮箱账号
        $smtpusermail = ASAIMAIL;
        //你的邮箱账号(去掉@126.com)
        $smtpuser = "eesaicom";//你的126邮箱去掉后面的126.com
//你的邮箱密码
        $smtppass = "asaiwang02590"; //你的126邮箱SMTP的授权码，千万不要填密码！！！

//收件人邮箱
        if ($aifem == '') {
            $aifem = "4941172@qq.com";
        }
        //邮件主题
        if ($aifbt == '') {
            $aifbt = "来自阿赛工作室的邮件";
        }
        //邮件内容
        if ($aifnr == '') {
            $aifnr = "欢迎您回访阿赛工作室www.asai.wang，祝福您生活愉快！";
        } else {
            $aifnr .= '【友情提醒：这是一封系统邮件，请勿回复！】';
        }
        //邮件格式（HTML/TXT）,TXT为文本邮件
        $smtptype = "HTML";
        //这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp = new asaismtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
        //是否显示发送的调试信息
        //$smtp->debug = TRUE;
        $smtp->debug = false;
        //发送邮件
        $smtp->sendmail($aifem, $smtpusermail, $aifbt, $aifnr, $smtptype);
        return true;
    } else {
        return false;
    }
}

class asaismtp
{
    /* Public Variables */
    public $smtp_port;
    public $time_out;
    public $host_name;
    public $log_file;
    public $relay_host;
    public $debug;
    public $auth;
    public $user;
    public $pass;

    /* Private Variables */
    public $sock;

    /* Constractor */
    public function smtp($relay_host = "", $smtp_port = 25, $auth = false, $user, $pass)
    {
        $this->debug = false;
        $this->smtp_port = $smtp_port;
        $this->relay_host = $relay_host;
        $this->time_out = 30; //is used in fsockopen()
        $this->auth = $auth;//auth
        $this->user = $user;
        $this->pass = $pass;
        $this->host_name = "localhost"; //is used in HELO command
        $this->log_file = "";
        $this->sock = false;
    }

    /* Main Function */
    public function sendmail($to, $from, $subject = "", $body = "", $smtptype, $cc = "", $bcc = "", $additional_headers = "")
    {
        $mail_from = $this->get_address($this->strip_comment($from));
        $body = preg_replace("/(^|(\r\n))(\.)/", "\1.\3", $body);
        $header = "MIME-Version:1.0\r\n";
        if ($smtptype == "HTML") {
            $header .= "Content-Type:text/html\r\n";
        }
        $header .= "To: " . $to . "\r\n";
        if ($cc != "") {
            $header .= "Cc: " . $cc . "\r\n";
        }
        $header .= "From: $from<" . $from . ">\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        $header .= $additional_headers;
        $header .= "Date: " . date("r") . "\r\n";
        $header .= "X-Mailer:By Redhat (PHP/" . phpversion() . ")\r\n";
        list($msec, $sec) = explode(" ", microtime());
        $header .= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $mail_from . ">\r\n";
        $TO = explode(",", $this->strip_comment($to));

        if ($cc != "") {
            $TO = array_merge($TO, explode(",", $this->strip_comment($cc)));
        }
        if ($bcc != "") {
            $TO = array_merge($TO, explode(",", $this->strip_comment($bcc)));
        }
        $sent = true;
        foreach ($TO as $rcpt_to) {
            $rcpt_to = $this->get_address($rcpt_to);
            if (!$this->smtp_sockopen($rcpt_to)) {
                $this->log_write("Error: Cannot send email to " . $rcpt_to . "\n");
                $sent = false;
                continue;
            }
            if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body)) {
                $this->log_write("E-mail has been sent to <" . $rcpt_to . ">\n");
            } else {
                $this->log_write("Error: Cannot send email to <" . $rcpt_to . ">\n");
                $sent = false;
            }
            fclose($this->sock);
            $this->log_write("Disconnected from remote host\n");
        }
        return $sent;
    }

    /* Private Functions */

    public function get_address($address)
    {
        $address = preg_replace("/([ \t\r\n])+/", "", $address);
        $address = preg_replace("/^.*<(.+)>.*$/", "\1", $address);
        return $address;
    }

    public function strip_comment($address)
    {
        $comment = "/\([^()]*\)/";
        while (preg_match($comment, $address)) {
            $address = preg_replace($comment, "", $address);
        }
        return $address;
    }

    public function smtp_sockopen($address)
    {
        if ($this->relay_host == "") {
            return $this->smtp_sockopen_mx($address);
        } else {
            return $this->smtp_sockopen_relay();
        }
    }

    public function smtp_sockopen_mx($address)
    {
        $domain = preg_replace('/^.+@([^@]+)$/', '\1', $address);
        if (!@getmxrr($domain, $MXHOSTS)) {
            $this->log_write("Error: Cannot resolve MX \"" . $domain . "\"\n");
            return false;
        }
        foreach ($MXHOSTS as $host) {
            $this->log_write("Trying to " . $host . ":" . $this->smtp_port . "\n");
            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);
            if (!($this->sock && $this->smtp_ok())) {
                $this->log_write("Warning: Cannot connect to mx host " . $host . "\n");
                $this->log_write("Error: " . $errstr . " (" . $errno . ")\n");
                continue;
            }
            $this->log_write("Connected to mx host " . $host . "\n");
            return true;
        }
        $this->log_write("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")\n");
        return false;
    }

    public function log_write($message)
    {
        $this->smtp_debug($message);
        if ($this->log_file == "") {
            return true;
        }
        $message = date("M d H:i:s ") . get_current_user() . "[" . getmypid() . "]: " . $message;
        if (!@file_exists($this->log_file) || !($fp = @fopen($this->log_file, "a"))) {
            $this->smtp_debug("Warning: Cannot open log file \"" . $this->log_file . "\"\n");
            return false;
            ;
        }
        flock($fp, LOCK_EX);
        fputs($fp, $message);
        fclose($fp);
        return true;
    }

    public function smtp_debug($message)
    {
        if ($this->debug) {
            echo $message;
        }
    }

    public function smtp_ok()
    {
        $response = str_replace("\r\n", "", fgets($this->sock, 512));
        $this->smtp_debug($response . "\n");
        if (!preg_match("/^[23]/", $response)) {
            fputs($this->sock, "QUIT\r\n");
            fgets($this->sock, 512);
            $this->log_write("Error: Remote host returned \"" . $response . "\"\n");
            return false;
        }
        return true;
    }

    public function smtp_sockopen_relay()
    {
        $this->log_write("Trying to " . $this->relay_host . ":" . $this->smtp_port . "\n");
        $this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);
        if (!($this->sock && $this->smtp_ok())) {
            $this->log_write("Error: Cannot connenct to relay host " . $this->relay_host . "\n");
            $this->log_write("Error: " . $errstr . " (" . $errno . ")\n");
            return false;
        }
        $this->log_write("Connected to relay host " . $this->relay_host . "\n");
        return true;
        ;
    }

    public function smtp_send($helo, $from, $to, $header, $body = "")
    {
        if (!$this->smtp_putcmd("HELO", $helo)) {
            return $this->smtp_error("sending HELO command");
        }

        #auth
        if ($this->auth) {
            if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {
                return $this->smtp_error("sending HELO command");
            }
            if (!$this->smtp_putcmd("", base64_encode($this->pass))) {
                return $this->smtp_error("sending HELO command");
            }
        }
        if (!$this->smtp_putcmd("MAIL", "FROM:<" . $from . ">")) {
            return $this->smtp_error("sending MAIL FROM command");
        }
        if (!$this->smtp_putcmd("RCPT", "TO:<" . $to . ">")) {
            return $this->smtp_error("sending RCPT TO command");
        }
        if (!$this->smtp_putcmd("DATA")) {
            return $this->smtp_error("sending DATA command");
        }
        if (!$this->smtp_message($header, $body)) {
            return $this->smtp_error("sending message");
        }
        if (!$this->smtp_eom()) {
            return $this->smtp_error("sending <CR><LF>.<CR><LF> [EOM]");
        }
        if (!$this->smtp_putcmd("QUIT")) {
            return $this->smtp_error("sending QUIT command");
        }
        return true;
    }

    public function smtp_putcmd($cmd, $arg = "")
    {
        if ($arg != "") {
            if ($cmd == "") {
                $cmd = $arg;
            } else {
                $cmd = $cmd . " " . $arg;
            }
        }
        fputs($this->sock, $cmd . "\r\n");
        $this->smtp_debug("> " . $cmd . "\n");
        return $this->smtp_ok();
    }

    public function smtp_error($string)
    {
        $this->log_write("Error: Error occurred while " . $string . ".\n");
        return false;
    }

    public function smtp_message($header, $body)
    {
        fputs($this->sock, $header . "\r\n" . $body);
        $this->smtp_debug("> " . str_replace("\r\n", "\n" . "> ", $header . "\n> " . $body . "\n> "));
        return true;
    }

    public function smtp_eom()
    {
        fputs($this->sock, "\r\n.\r\n");
        $this->smtp_debug(". [EOM]\n");
        return $this->smtp_ok();
    }
}

// echo G_BFL.'<BR>';// id,en,eb,ep,xy
// echo sailie("ai", G_BFL, 0).'<BR>';// ai_id,ai_en,ai_eb,ai_ep,ai_xy
// echo sailie("ai", G_BFL, 1).'<BR>';// ai_en,ai_eb,ai_ep,ai_xy
// echo sailie("ai", G_BFL, 2).'<BR>';// ai_id,ai_en,ai_eb,ai_ep
// echo sailie("ai", G_BFL, 3).'<BR>';// ai_en,ai_eb,ai_ep
function sailie($aifmz, $aifstr, $aifty)
{
    $aidnew="";
    if ($aifty===0) {
        $aidnew=$aifmz.'_'.str_replace(',', ','.$aifmz.'_', $aifstr);
    } elseif ($aifty===1) {
        $aidnew=$aifmz.'_'.str_replace(',', ','.$aifmz.'_', str_replace('id,', '', $aifstr));
    } else {
        $aidarr=explode(',', $aifstr);
        $aidlen=count($aidarr);
        if ($aifty===2) {
            $aidnew=$aifmz.'_'.$aidarr[0];
        }
        for ($aidi=1;$aidi<$aidlen;$aidi++) {
            $aidk=substr($aidarr[$aidi], 0, 1);
            if ($aidk==='e') {
                if ($aidnew!=="") {
                    $aidnew=$aidnew.',';
                }
                $aidnew=$aidnew.$aifmz.'_'.$aidarr[$aidi];
            }
        }
    }
    return $aidnew;
}
