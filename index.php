<?php
include_once 'db.php';
include_once 'asai.php';
$output = array();


if ($g_u0 == 'uj') {
    if (aiconn(G_CONN)) {
        if ($g_u1 == 'list') {
            $output = saiout(0, 'list', sailist("uj", "uj_id", gb("uj", G_BUJ, 0), "uj_id>0", "uj_id desc", $g_u2, $g_u3));
        } elseif ($g_u1 == 'top') {
            $output = saiout(0, 'top', saitop("uj", gb("uj", G_BUJ, 0), "uj_id>0", "uj_id desc", $g_u2));
        } elseif ($g_u1 == 'info') {
            $output = saiout(0, 'info', saiview("uj", gb("uj", G_BUJ, 0), "uj_id=" . $g_u2 . ""));
        } elseif ($g_u1 == 'edit') {
            $output = saiout(0, 'edit', saido("uj", gb("uj", G_BFL, 1), saipost(), "uj_id=" . $g_u2));
        } elseif ($g_u1 == 'add') {
            $output = saiout(0, 'add', saido("uj", gb("uj", G_BFL, 1), saipost(), 0));
        } elseif ($g_u1 == 'del') {
            $output = saiout(0, 'del', saidel("uj", "uj_id=" . $g_u2));
        } else {
        }
        aiconn(0);
    } else {
        $output = saiout(2, 'err', G_COBB);
    }
} else {
    $output = saiout(4, 'err', G_ERRS);
}

exit(urldecode(json_encode($output)));//把结果反馈给客户端，如果是中文的话，使用这个urldecode恢复转码
