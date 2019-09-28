<?php
//header("Content-Type:text/plain;charset=utf-8");
header("Content-Type:application/json;charset=utf-8");
//header("Content-Type:text/html;charset=utf-8");
header("Cache-Control:no-cache");//�����������Ҫ��������

header('Access-Control-Allow-Origin:*');//����������Ҫ���õ�������
header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//�����������ʽ��
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//�������������ͷ��

// $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
// 
//  $allow_origin = array(
//     'http://localhost',
// 	'http:http://localhost',
//     'http://localhost:909',
//     'http://localhost:63342'
// );
// if (in_array($origin, $allow_origin)) { 
// //header("Access-Control-Allow-Origin: *");//����������Ҫ���õ�������
// header("Access-Control-Allow-Origin:http:".$origin."");//����������Ҫ���õ�������
// header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//�����������ʽ��
// header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//�������������ͷ��
// header("Access-Control-Allow-Max-Age:28000");//��ʾ��Preflight�����ʱ��(��),�ڼ��������ٴη���Ԥ����
// header("Access-Control-Allow-Credentials-Header:true");//���������ܴ�ƾ�ݵ�������õ�HTTPͷ����Ӧ
// 
// }


define("G_CONN", realpath("asaimdb.mdb"));//���ݿ������ַ�.
define("G_COBB", "�������ݿ����ӣ�");//���ݿ����Ӵ����׳�������ʾ.
define("G_NULL", "û�в�ѯ������Ҫ�����ݣ�");//SQL�ɹ���û�в�ѯ������.
define("G_ERRS", "�ܱ�Ǹ������ط�û������Ҫ�����ݣ�");//��ȡAPI���������׳�������ʾ.
define("G_ERR", 0);//���Կ���-0�رյ���|1��������|2�߼�����*�Ƿ������Թ���.
define("G_PGS", 20);//��ҳ��ÿҳ��ʾ����
define("G_GMM", "Gys.Z1nHdFYefo@Q2pqrxUAjBI~WzCwEaRtSc9Kh=TkP6XiJNuOMv5_0D3Vg4b7mL8l-");//��Կ�ִ�:ϵͳ��Կ�ַ�����һ�����ý����޸�.
define("ASAIMAIL", "eesaicom@126.com");//ϵͳ�ʼ����ռ�����Ҫ�����ʼ���Ϊ�����������ⷢ����������������ʧ��

include_once 'asai.php';

$output = array();

//$mydata=array("uj_ty"=>1,"uj_us"=>'asai',"uj_co"=>'����һ�����ģ������õģ�',"uj_tm"=>'2018/12/19 21:10:00');
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
exit(urldecode(json_encode($output)));//�ѽ���������ͻ��ˣ���������ĵĻ���ʹ�����urldecode�ָ�ת��
?>