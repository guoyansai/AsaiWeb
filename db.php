<?php
header("Content-Type:application/json;charset=utf-8");
header("Cache-Control:no-cache");//告诉浏览器不要缓存数据
header('Access-Control-Allow-Origin:*');//就是我们需要设置的域名。
header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//是允许的请求方式。
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//跨域允许包含的头。

define("G_BUS", "id,es,er,ex,eb,em,eh,et,ab,aq,ax,as,al,aj,ap,xy");//会员
define("G_BUU", "id,ef,af,ej,aj,as,al,xt");//好友
define("G_BUN", "id,es,er,eb,ec,as,al,aj,xy,xe,xt");//群聚
define("G_BUX", "id,eo,ey,ej,af,as,at");//短信
define("G_BUJ", "id,ey,er,eo,as");//记录
define("G_BFL", "id,en,eb,ep,xy");//分类
define("G_BAI", "id,en,eb,ef,ey,er,ez,ed,eu,eo,as,al,ah,ax,ay,xy");//内容

define("G_CONN", realpath("asaimdb.mdb"));//数据库连接字符.
define("G_Q", "asai_");//数据表前缀名.
define("G_COBB", "请检查数据库连接！");//数据库连接错误抛出错误提示.
define("G_NULL", "没有查询到您需要的数据！");//SQL成功后没有查询到数据.
define("G_ERRS", "很抱歉，这个地方没有您需要的数据！");//读取API参数错误抛出错误提示.
define("G_ERR", 0);//调试开关-0关闭调试|1开启调试|2高级调试*是否开启调试功能.
define("G_PGS", 20);//分页中每页显示数量
define("G_GMM", "Gys.Z1nHdFYefo@Q2pqrxUAjBI~WzCwEaRtSc9Kh=TkP6XiJNuOMv5_0D3Vg4b7mL8l-");//密钥字串:系统密钥字符设置一经启用谨慎修改.
define("ASAIMAIL", "eesaicom@126.com");//系统邮件，收件人需要将该邮件设为白名单，以免发件被当做垃圾件丢失。

// echo G_BFL.'<BR>';// id,en,eb,ep,xy
// echo gb("ai", G_BFL, 0).'<BR>';// ai_id,ai_en,ai_eb,ai_ep,ai_xy
// echo gb("ai", G_BFL, 1).'<BR>';// ai_en,ai_eb,ai_ep,ai_xy
// echo gb("ai", G_BFL, 2).'<BR>';// ai_id,ai_en,ai_eb,ai_ep
// echo gb("ai", G_BFL, 3).'<BR>';// ai_en,ai_eb,ai_ep

function gb($aifmz, $aifstr, $aifty)
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
