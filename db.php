<?php
header("Content-Type:application/json;charset=utf-8");
header("Cache-Control:no-cache");//�����������Ҫ��������
header('Access-Control-Allow-Origin:*');//����������Ҫ���õ�������
header("Access-Control-Allow-Methods:POST, GET, OPTIONS");//�����������ʽ��
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");//�������������ͷ��

define("G_BUS", "id,es,er,ex,eb,em,eh,et,ab,aq,ax,as,al,aj,ap,xy");//��Ա
define("G_BUU", "id,ef,af,ej,aj,as,al,xt");//����
define("G_BUN", "id,es,er,eb,ec,as,al,aj,xy,xe,xt");//Ⱥ��
define("G_BUX", "id,eo,ey,ej,af,as,at");//����
define("G_BUJ", "id,ey,er,eo,as");//��¼
define("G_BFL", "id,en,eb,ep,xy");//����
define("G_BAI", "id,en,eb,ef,ey,er,ez,ed,eu,eo,as,al,ah,ax,ay,xy");//����

define("G_CONN", realpath("asaimdb.mdb"));//���ݿ������ַ�.
define("G_Q", "asai_");//���ݱ�ǰ׺��.
define("G_COBB", "�������ݿ����ӣ�");//���ݿ����Ӵ����׳�������ʾ.
define("G_NULL", "û�в�ѯ������Ҫ�����ݣ�");//SQL�ɹ���û�в�ѯ������.
define("G_ERRS", "�ܱ�Ǹ������ط�û������Ҫ�����ݣ�");//��ȡAPI���������׳�������ʾ.
define("G_ERR", 0);//���Կ���-0�رյ���|1��������|2�߼�����*�Ƿ������Թ���.
define("G_PGS", 20);//��ҳ��ÿҳ��ʾ����
define("G_GMM", "Gys.Z1nHdFYefo@Q2pqrxUAjBI~WzCwEaRtSc9Kh=TkP6XiJNuOMv5_0D3Vg4b7mL8l-");//��Կ�ִ�:ϵͳ��Կ�ַ�����һ�����ý����޸�.
define("ASAIMAIL", "eesaicom@126.com");//ϵͳ�ʼ����ռ�����Ҫ�����ʼ���Ϊ�����������ⷢ����������������ʧ��

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
