<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Utils\PaymentUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AddressController extends Controller
{
    public function getAddressPage()
    {
        $commune = PaymentUtils::getTreeData();
        $addresses = Address::where('user_id', Auth::id())->get();
        $provinces = PaymentUtils::getProvinceData();
        $communeData = PaymentUtils::getAllCommuneData();

        foreach ($addresses as $address) {
            if (isset($communeData[$address->commune])) {
                $address->path_with_type = $communeData[$address->commune]['path_with_type'];
            } else {
                $address->path_with_type = '';
            }
        }

        return view('pages.user.address', compact('provinces', 'addresses'));
    }

    public function getDistrictList(Request $req)
    {
        try {
            $provinceId = $req->province;
            $districts = PaymentUtils::getDistrictData($provinceId);

            if (empty($districts)) {
                echo '<option> Không có dữ liệu </option>';
            }

            $options = [];
            foreach ($districts as $district) {
                $options[] = '<option value="' . $district['code'] . '">' . $district['name_with_type'] . '</option>';
            }

            echo implode("\n", $options);
        } catch (Throwable) {
            echo '<option> Không có dữ liệu </option>';
        }
    }

    public function getCommuneList(Request $req)
    {
        try {
            $communeId = $req->district;
            $communes = PaymentUtils::getCommuneData($communeId);

            if (empty($communes)) {
                echo '<option> Không có dữ liệu </option>';
            }

            $options = [];
            foreach ($communes as $commune) {
                $options[] = '<option value="' . $commune['code'] . '">' . $commune['name_with_type'] . '</option>';
            }

            echo implode("\n", $options);
        } catch (Throwable) {
            echo '<option> Không có dữ liệu </option>';
        }
    }

    public function addAddress(Request $req)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'province' => 'required',
                'district' => 'required',
                'commune' => 'required',
            ], [
                'name.required' => 'Vui lòng nhập tên người nhận.',
                'name.max' => 'Tên người nhận không được vượt quá 255 ký tự.',

                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.max' => 'Số điện thoại sai định dạng',

                'province.required' => 'Vui lòng chọn tỉnh/thành phố.',
                'district.required' => 'Vui lòng chọn quận/huyện.',
                'commune.required' => 'Vui lòng chọn xã/phường.',
            ]);

            if ($validator->fails()) {
                return $this->responseAjax(null, $validator->getMessageBag()->first());
            }

            $treeAddress = PaymentUtils::getTreeData();
            if (!isset($treeAddress[$req->province]['quan-huyen'][$req->district]['xa-phuong'][$req->commune])) {
                return $this->responseAjax(null, 'Thông tin địa chỉ không đúng');
            }

            $address = new Address();
            $address->user_name = $req->name;
            $address->phone = $req->phone;
            $address->province = $req->province;
            $address->district = $req->district;
            $address->commune = $req->commune;
            $address->address_detail = $req->address_detail;
            $address->user_id = Auth::id();
            $address->save();

            DB::commit();
            return $this->responseAjax(['id' => $address->id]);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->responseAjax(null, 'Đã có lỗi xảy ra.');
        }
    }

    public function deleteAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$address) {
            return $this->responseAjax(null, 'Địa chỉ không tồn tại.');
        }

        $address->delete();
        return $this->responseAjax(['id' => $id]);
    }

    public function getAddress($id)
    {
        $address = Address::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$address) {
            return $this->responseAjax(null, 'Địa chỉ không tồn tại.');
        }
        return response()->json($address);
    }

    public function updateAddress(Request $req, $id)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'province' => 'required',
                'district' => 'required',
                'commune' => 'required',
            ], [
                'name.required' => 'Vui lòng nhập tên người nhận.',
                'name.max' => 'Tên người nhận không được vượt quá 255 ký tự.',

                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.max' => 'Số điện thoại sai định dạng',

                'province.required' => 'Vui lòng chọn tỉnh/thành phố.',
                'district.required' => 'Vui lòng chọn quận/huyện.',
                'commune.required' => 'Vui lòng chọn xã/phường.',
            ]);

            if ($validator->fails()) {
                return $this->responseAjax(null, $validator->getMessageBag()->first());
            }

            $treeAddress = PaymentUtils::getTreeData();
            if (!isset($treeAddress[$req->province]['quan-huyen'][$req->district]['xa-phuong'][$req->commune])) {
                return $this->responseAjax(null, 'Thông tin địa chỉ không đúng');
            }

            $address = Address::where('user_id', Auth::id())->where('id', $id)->first();
            if (!$address) {
                return $this->responseAjax(null, 'Địa chỉ không tồn tại.');
            }

            $address->user_name = $req->name;
            $address->phone = $req->phone;
            $address->province = $req->province;
            $address->district = $req->district;
            $address->commune = $req->commune;
            $address->address_detail = $req->address_detail;
            $address->save();

            DB::commit();
            return $this->responseAjax(['id' => $address->id]);
        } catch (Throwable $ex) {
            DB::rollBack();
            return $this->responseAjax(null, 'Đã có lỗi xảy ra.');
        }
    }
}
