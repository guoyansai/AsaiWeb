<?php
include_once 'asaiconfig.php';
include_once 'asai.php';

if ($g_u0 == 'index'||($g_u0 == ''&&$g_u1 == '')) {
    header("Content-type: text/html; charset=utf-8");
    $urqz="?uj/";
    echo "<a href='".$urqz."list'>List</a><BR>";
    echo "<a href='".$urqz."top/10'>top</a><BR>";
    echo "<a href='".$urqz."info/2'>info</a><BR>";
    echo "<a href='".$urqz."edit/2'>edit</a><BR>";
    echo "<a href='".$urqz."add'>add</a><BR>";
    echo "<a href='".$urqz."del/3'>del</a><BR>";
} else {
    $aifqz='';
    $aifdb='';
    if ($g_u0 == 'uj') {
        $aifqz=$g_u0;
        $aifdb=G_BUJ;
    } elseif ($g_u0 == 'us') {
        $aifqz=$g_u0;
        $aifdb=G_BUS;
    }
    if ($aifqz!==''&&$aifdb!=='') {
        if (aiconn(G_CONN)) {
            if ($g_u1 == 'list') {
                $output = saiout(0, 'list', sailist($aifqz, $aifqz."_id", sailie($aifqz, $aifdb, 0), $aifqz."_id>0", $aifqz."_id desc", $g_u2, $g_u3));
            } elseif ($g_u1 == 'top') {
                $output = saiout(0, 'top', saitop($aifqz, sailie($aifqz, $aifdb, 0), $aifqz."_id>0", $aifqz."_id desc", $g_u2));
            } elseif ($g_u1 == 'info') {
							// echo sailie($aifqz, $aifdb, 0);
                $output = saiout(0, 'info', saiview($aifqz, sailie($aifqz, $aifdb, 0), $aifqz."_id=" . $g_u2 . ""));
            } elseif ($g_u1 == 'edit') {
                $output = saiout(0, 'edit', saido($aifqz, sailie($aifqz,$aifdb, 1), saipost(), $aifqz."_id=" . $g_u2));
            } elseif ($g_u1 == 'add') {
                $output = saiout(0, 'add', saido($aifqz, sailie($aifqz, $aifdb, 1), saipost(), 0));
            } elseif ($g_u1 == 'del') {
                $output = saiout(0, 'del', saidel($aifqz, $aifqz."_id=" . $g_u2));
            } else {
                $output = saiout(2, 'err', G_COEP);
            }
            aiconn(0);
        } else {
            $output = saiout(2, 'err', G_COBB);
        }
    } else {
        $output = saiout(4, 'err', G_ERRS);
    }

    exit(urldecode(json_encode($output)));//把结果反馈给客户端，如果是中文的话，使用这个urldecode恢复转码
}
