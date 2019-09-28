<?php
//header("Content-Type:text/plain;charset=utf-8");
header("Content-Type:application/json;charset=utf-8");
//header("Content-Type:text/html;charset=utf-8");
header("Cache-Control:no-cache");//告诉浏览器不要缓存数据

header('Access-Control-Allow-Origin:*');//就是我们需要设置的域名。
header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//是允许的请求方式。
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//跨域允许包含的头。

// $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
// 
//  $allow_origin = array(
//     'http://localhost',
// 	'http:http://localhost',
//     'http://localhost:909',
//     'http://localhost:63342'
// );
// if (in_array($origin, $allow_origin)) { 
// //header("Access-Control-Allow-Origin: *");//就是我们需要设置的域名。
// header("Access-Control-Allow-Origin:http:".$origin."");//就是我们需要设置的域名。
// header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//是允许的请求方式。
// header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//跨域允许包含的头。
// header("Access-Control-Allow-Max-Age:28000");//表示将Preflight缓存的时长(秒),期间内无需再次发送预请求
// header("Access-Control-Allow-Credentials-Header:true");//服务器接受带凭据的请求会用的HTTP头部响应
// 
// }


define("G_CONN", realpath("asaimdb.mdb"));//数据库连接字符.
define("G_COBB", "请检查数据库连接！");//数据库连接错误抛出错误提示.
define("G_NULL", "没有查询到您需要的数据！");//SQL成功后没有查询到数据.
define("G_ERRS", "很抱歉，这个地方没有您需要的数据！");//读取API参数错误抛出错误提示.
define("G_ERR", 0);//调试开关-0关闭调试|1开启调试|2高级调试*是否开启调试功能.
define("G_PGS", 20);//分页中每页显示数量
define("G_GMM", "Gys.Z1nHdFYefo@Q2pqrxUAjBI~WzCwEaRtSc9Kh=TkP6XiJNuOMv5_0D3Vg4b7mL8l-");//密钥字串:系统密钥字符设置一经启用谨慎修改.
define("ASAIMAIL", "eesaicom@126.com");//系统邮件，收件人需要将该邮件设为白名单，以免发件被当做垃圾件丢失。

include_once 'asai.php';

$output = array();

//$mydata=array("uj_ty"=>1,"uj_us"=>'asai',"uj_co"=>'这是一个信心，测试用的！',"uj_tm"=>'2018/12/19 21:10:00');
//print_r($mydata);
//$output = saiout(0, 'useradd', saido("asai_uj", "uj_ty,uj_us,uj_co,uj_tm", $mydata,0));

if ($g_u0 == 'ai') {
    if (aiconn(G_CONN)) {
        if ($g_u1 == 'info') {
            $output = saiout(0, 'info', saiview("ees_ai", "ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_id=" . $g_u2 . ""));
        } elseif ($g_u1 == 'list') {
            $output = saiout(0, 'list', sailist("ees_ai", "ai_id","ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2, $g_u3));
        } elseif ($g_u1 == 'top') {
            $output = saiout(0, 'top', saitop("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2));
        } elseif ($g_u1 == 'edit') {
           $output = saiout(0, 'edit', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", saipost(),"ai_id=" . $g_u2));
        } elseif ($g_u1 == 'add') {
            $output = saiout(0, 'add', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us", saipost(), 0));
        } elseif ($g_u1 == 'del') {
            $output = saiout(0, 'userdel', saidel("ees_ai", "ai_id=" . $g_u2));
        } else {

        }
        aiconn(0);
    } else {
        $output = saiout(2, 'err', G_COBB);
    }
} elseif ($g_u0 == 'user') {
    if (aiconn(G_CONN)) {
        if ($g_u1 == 'view') {
            $output = saiout(0, 'userinfo', saiview("ees_ai", "ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_sn='" . $g_u2 . "'"));
        } elseif ($g_u1 == 'list') {
            $output = saiout(0, 'userlist', sailist("ees_ai", "ai_id","ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2, $g_u3));
        } elseif ($g_u1 == 'top') {
            $output = saiout(0, 'usertop', saitop("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2));
        } elseif ($g_u1 == 'show') {
           $output = saiout(0, 'usershow', saiview("ees_ai", "ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_id=" . $g_u2 . ""));
        } elseif ($g_u1 == 'edit') {
           $output = saiout(0, 'useredit', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", saipost(),"ai_id=" . $g_u2));
        } elseif ($g_u1 == 'add') {
            $output = saiout(0, 'postadd', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", saipost(), 0));
        } elseif ($g_u1 == 'adduj') {
            $output = saiout(0, 'postadd', saido("asai_uj", "uj_ty,uj_co,uj_us,uj_tm", saipost(), 0));
        } elseif ($g_u1 == 'del') {
            $output = saiout(0, 'userdel', saidel("ees_ai", "ai_id=" . $g_u2));
        } else {

        }
        aiconn(0);
    } else {
        $output = saiout(2, 'err', G_COBB);
    }
} elseif ($g_u0 == 'content') {
    if (aiconn(G_CONN)) {
        if ($g_u1 == 'list') {
            $output = saiout(0, 'list', sailist("ees_ai", "ai_id","ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2, $g_u3));
        } elseif ($g_u1 == 'top') {
            $output = saiout(0, 'top', saitop("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_xy>0", "ai_id desc", $g_u2));
        } elseif ($g_u1 == 'view') {
            $output = saiout(0, 'view', saiview("ees_ai", "ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_sn='" . $g_u2 . "'"));
        } elseif ($g_u1 == 'show') {
           $output = saiout(0, 'show', saiview("ees_ai", "ai_id,ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", "ai_id=" . $g_u2 . ""));
        } elseif ($g_u1 == 'edit') {
           $output = saiout(0, 'edit', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", saipost(),"ai_id=" . $g_u2));
        } elseif ($g_u1 == 'add') {
            $output = saiout(0, 'add', saido("ees_ai", "ai_sn,ai_bt,ai_fl,ai_us,ai_dj,ai_tm,ai_t1,ai_xy,ai_hi,ai_xi,ai_xo,ai_up,ai_nr", saipost(), 0));
        } elseif ($g_u1 == 'del') {
            $output = saiout(0, 'del', saidel("ees_ai", "ai_id=" . $g_u2));
        } else {

        }
        aiconn(0);
    } else {
        $output = saiout(2, 'err', G_COBB);
    }
} elseif ($g_u0 == 'uj') {
    if (aiconn(G_CONN)) {
        if ($g_u1 == 'list') {
            $output = saiout(0, 'list', sailist("asai_uj", "uj_id","uj_id,uj_ty,uj_co,uj_us,uj_tm", "uj_id>0", "uj_id desc", $g_u2, $g_u3));
        } elseif ($g_u1 == 'top') {
            $output = saiout(0, 'top', saitop("asai_uj", "uj_id,uj_ty,uj_co,uj_us,uj_tm", "uj_id>0", "uj_id desc", $g_u2));
        } elseif ($g_u1 == 'info') {
           $output = saiout(0, 'info', saiview("asai_uj", "uj_id,uj_ty,uj_co,uj_us,uj_tm", "uj_id=" . $g_u2 . ""));
        } elseif ($g_u1 == 'edit') {
           $output = saiout(0, 'edit', saido("asai_uj", "uj_ty,uj_co,uj_us,uj_tm", saipost(),"uj_id=" . $g_u2));
        } elseif ($g_u1 == 'add') {
            $output = saiout(0, 'add', saido("asai_uj", "uj_ty,uj_co,uj_us,uj_tm", saipost(), 0));
        } elseif ($g_u1 == 'del') {
            $output = saiout(0, 'del', saidel("asai_uj", "uj_id=" . $g_u2));
        } else {

        }
        aiconn(0);
    } else {
        $output = saiout(2, 'err', G_COBB);
    }

} else {
    $output = saiout(4, 'err', G_ERRS);
}

//print_r(saijie($output));
//print_r(json_encode($output));
//print_r(urldecode(json_encode($output)));
exit(urldecode(json_encode($output)));//把结果反馈给客户端，如果是中文的话，使用这个urldecode恢复转码
?>