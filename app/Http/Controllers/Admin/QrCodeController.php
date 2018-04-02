<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\MarketQrCode;
use App\Http\Models\OauthMemberBind;
use App\Http\Services\wechat\RequestService;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keywords = $request->get('keywords', '');
        $current_page = $request->get('p', 1);
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = MarketQrCode::query();
        if ($keywords) {
            $query->where('name', 'like', '%' . $keywords . '%');
        }

        $page = config('common.page');
        $page['total_count'] = $query->count();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;
        $query->with('qrcode_scan_histories');
        $qrcode_list = $query->where('expired_time', '>', date('Y-m-d H:i:s', time() + 3600))
            ->offset(($current_page - 1) * $page['page_size'])
            ->take($page['page_size'])
            ->get()
            ->toArray();

        $tmp_openid_arr = OauthMemberBind::all()
            ->pluck('openid')
            ->toArray();

        $concern = 0;
        foreach ($qrcode_list as $item) {
            if ($item['qrcode_scan_histories']) {
                foreach ($item['qrcode_scan_histories'] as $item1) {
                    foreach ($tmp_openid_arr as $tmp_openid) {
                        if ($item1['openid'] == $tmp_openid) {
                            $concern += 1;
                        }
                    }
                    $this->setRegCount($item1['qrcode_id'], $concern);
                }
            }
            $concern = 0;
        }


        return view('admin/qrcode/index', compact('qrcode_list', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/qrcode/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->post('name', '');
        if (!$name) {
            return ajaxReturn('请输入渠道名称~~~', -1);
        }

        $market_qrcode = new MarketQrCode();
        if (!$market_qrcode::checkUnique($name, 'name')) {
            return ajaxReturn('渠道名称已存在~~~', -1);
        }
        $market_qrcode->name = $name;
        $id = $market_qrcode->save();
        if (!$id) {
            return ajaxReturn('添加失败~~~', -1);
        }
        if (!$market_qrcode->qrcode) {
            $ret = $this->geneTmpQrcode($market_qrcode->id);
            if ($ret) {
                $market_qrcode->extra = json_encode($ret);
                $market_qrcode->expired_time = date("Y-m-d H:i:s",time() + $ret['expire_seconds'] );
                $market_qrcode->qrcode = isset($ret['url']) ? $ret['url'] : '';
                $market_qrcode->save();
                $this->makeQrCode($market_qrcode->qrcode, $market_qrcode->id);
            }
        }


        return ajaxReturn('添加成功~~~');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qrcode = MarketQrCode::find($id);
        return view('admin/qrcode/edit', compact('qrcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->post('name');
        if (!$name) {
            return ajaxReturn('请输入渠道名称~~~', -1);
        }
        $model_qrcode = MarketQrCode::find($id);
        if (!$model_qrcode) {
            return ajaxReturn('渠道不存在~~~', -1);
        }
        if (!$model_qrcode::checkUnique($name, 'name', $model_qrcode->name)) {
            return ajaxReturn('渠道名称已存在~~~', -1);
        }
        $model_qrcode->name = $name;
        $model_qrcode->save();

        return ajaxReturn('编辑成功~~~');
    }

    public function destroy($id)
    {
        $model_qrcode = MarketQrCode::find($id);
        if (!$model_qrcode) {
            return ajaxReturn('渠道不存在~~~', -1);
        }
        if ($model_qrcode->delete()) {
            if (file_exists('images/qrcodes/qrcode'. $id . '.png')) {
                unlink('images/qrcodes/qrcode' . $id . '.png');
            }
        }

        return ajaxReturn('删除成功~~~');
    }

    public function makeQrCode($qrcode_url, $id)
    {
        if (!is_dir('images/qrcodes')) {
            mkdir(iconv("UTF-8", "GBK", 'images/qrcodes'),0777,true);
        }
        QrCode::format('png')->size(120)->generate($qrcode_url, public_path("/images/qrcodes/qrcode{$id}.png"));
    }

    private function geneTmpQrCode($id)
    {
        RequestService::setApp();
        $token = RequestService::getAccessToken();
        $post_data = [
            'expire_seconds' => 2592000, //30天
            'action_name' => 'QR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_id' => $id
                ]
            ],
        ];

        return RequestService::send("qrcode/create?access_token={$token}", json_encode($post_data), 'POST');
    }

    public function setRegCount($qrcode_id, $count)
    {
        $model = MarketQrCode::find($qrcode_id);
        $model->total_reg_count = $count;
        $res = $model->save();

        return $res;
    }

}
