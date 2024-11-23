<?php
	
	namespace App\Http\Controllers\Admin\Accounts;
	use Validator;
	use App\tableList;
	use App\SmChartOfAccount;
	use App\SmSubHeadChartOfAccount;
	use Illuminate\Http\Request;
	use App\Http\Controllers\Controller;
	use Brian2694\Toastr\Facades\Toastr;
	use Illuminate\Support\Facades\Auth;
	use App\Http\Requests\Admin\Accounts\SmChartOfAccountRequest;
	
	class SmChartOfAccountController extends Controller
	{
		public function __construct()
		{
			$this->middleware('PM');
		}
		
		public function index()
		{
			try {
				$chart_of_accounts = SmChartOfAccount::get();
				return view('backEnd.accounts.chart_of_account', compact('chart_of_accounts'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function store(SmChartOfAccountRequest $request)
		{
			
			$validator = Validator::make($request->all(), [
            'head' => 'required',
			'head_code' => 'required|numeric'
			]);
			
			if ($validator->fails()) {
				Toastr::error($validator->getMessageBag()->first(), 'Failed');
				return redirect()->back()->withInput();
			}
			
			try {
				$chart_of_account = new SmChartOfAccount();
				$chart_of_account->head = $request->head;
				$chart_of_account->head_code = $request->head_code;
				$chart_of_account->type = $request->type;
				$chart_of_account->school_id = Auth::user()->school_id;
				if(moduleStatusCheck('University')){
					$chart_of_account->un_academic_id = getAcademicId();
					}else{
					$chart_of_account->academic_id = getAcademicId();
				}
				$chart_of_account->save();
				$id = $chart_of_account->id;
				
				foreach($request->sub_head as $key => $postvalue) {
					
					$sub_head_chart_of_account = new SmSubHeadChartOfAccount();
					$sub_head_chart_of_account->head_id = $id ;
					$sub_head_chart_of_account->head_sub = $request->sub_head[$key];
					$sub_head_chart_of_account->head_sub_code = $request->sub_head_code[$key];
					$key = $key + 1;
					if(!empty($request->sub_sub_head[$key])) {
						$sub_sub_head = [];
						$sub_sub_head_code = [];
						foreach($request->sub_sub_head[$key] as $keysub => $postvaluesub) {
							$sub_sub_head[] = $request->sub_sub_head[$key][$keysub];
							$sub_sub_head_code[] = $request->sub_sub_head_code[$key][$keysub];
							
						}
						$sub_head_chart_of_account->head_sub_sub = implode(',',$sub_sub_head);
						$sub_head_chart_of_account->head_sub_sub_code = implode(',',$sub_sub_head_code);
					}
					
					$sub_head_chart_of_account->school_id = Auth::user()->school_id;
					if(moduleStatusCheck('University')){
						$sub_head_chart_of_account->un_academic_id = getAcademicId();
						}else{
						$sub_head_chart_of_account->academic_id = getAcademicId();
					}
					$sub_head_chart_of_account->save();
				}
				
				Toastr::success('Operation successful', 'Success');
				return redirect()->back();
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function show($id)
		{
			try {
				$chart_of_account = SmChartOfAccount::find($id);
				$chart_of_accounts = SmChartOfAccount::get();
				$sub_head_chart_of_accounts = SmSubHeadChartOfAccount::where('head_id',$id)->get();
				
				foreach($sub_head_chart_of_accounts as $key => $value) {
					$sub_head_chart_of_accounts[$key]->head_sub_sub = explode(',',$value->head_sub_sub);
					$sub_head_chart_of_accounts[$key]->head_sub_sub_code = explode(',',$value->head_sub_sub_code);
				}
				
				
				return view('backEnd.accounts.chart_of_account', compact('chart_of_account', 'chart_of_accounts','sub_head_chart_of_accounts'));
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function update(SmChartOfAccountRequest $request, $id)
		{
			$validator = Validator::make($request->all(), [
            'head' => 'required',
			'head_code' => 'required|numeric'
			]);
			
			if ($validator->fails()) {
				Toastr::error($validator->getMessageBag()->first(), 'Failed');
				return redirect()->back()->withInput();
			}
			try {
				$chart_of_account = SmChartOfAccount::find($request->id);
				$chart_of_account->head = $request->head;
				$chart_of_account->head_code = $request->head_code;
				$chart_of_account->type = $request->type;
				if(moduleStatusCheck('University')){
					$chart_of_account->un_academic_id = getAcademicId();
				}
				$chart_of_account->save();
				
				SmSubHeadChartOfAccount::where('head_id',$request->id)->delete(); 
				foreach($request->sub_head as $key => $postvalue) {
					$sub_head_chart_of_account = new SmSubHeadChartOfAccount();
					$sub_head_chart_of_account->head_id = $id ;
					$sub_head_chart_of_account->head_sub = $request->sub_head[$key];
					$sub_head_chart_of_account->head_sub_code = $request->sub_head_code[$key];
					$key = $key + 1;
					if(!empty($request->sub_sub_head[$key])) {
						$sub_sub_head = [];
						$sub_sub_head_code = [];
						foreach($request->sub_sub_head[$key] as $keysub => $postvaluesub) {
							$sub_sub_head[] = $request->sub_sub_head[$key][$keysub];
							$sub_sub_head_code[] = $request->sub_sub_head_code[$key][$keysub];
							
						}
						$sub_head_chart_of_account->head_sub_sub = implode(',',$sub_sub_head);
						$sub_head_chart_of_account->head_sub_sub_code = implode(',',$sub_sub_head_code);
					}
					
					$sub_head_chart_of_account->school_id = Auth::user()->school_id;
					if(moduleStatusCheck('University')){
						$sub_head_chart_of_account->un_academic_id = getAcademicId();
						}else{
						$sub_head_chart_of_account->academic_id = getAcademicId();
					}
					$sub_head_chart_of_account->save();
				}
				
				Toastr::success('Operation successful', 'Success');
				return redirect()->route('chart-of-account');
				} catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function destroy(Request $request, $id)
		{
			try{
				$tables1 = tableList::getTableList('income_head_id', $id);
				$tables2 = tableList::getTableList('expense_head_id', $id);
				try {
					if ($tables1 ==null && $tables2 ==null){
						$chart_of_account = SmChartOfAccount::destroy($id);
						
						Toastr::success('Operation successful', 'Success');
						return redirect()->back();
						}else{
						$msg = 'This data already used in  : ' . $tables1 .' '. $tables2 .' Please remove those data first';
						Toastr::error($msg, 'Failed');
						return redirect()->back();
					}
					} catch (\Illuminate\Database\QueryException $e) {
					$msg = 'This data already used in  : '. $tables1 .' '. $tables2 .' Please remove those data first';
					Toastr::error($msg, 'Failed');
					return redirect()->back();
					} catch (\Exception $e) {
					Toastr::error('Operation Failed', 'Failed');
					return redirect()->back();
				}
				}catch (\Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function getChartOfAccount(Request $request){
			$chart_of_account = SmChartOfAccount::find($request->chart_id);
				$sub_head_chart_of_accounts = SmSubHeadChartOfAccount::where('head_id',$request->chart_id)->get();
				
				foreach($sub_head_chart_of_accounts as $key => $value) {
					$sub_head_chart_of_accounts[$key]->head_sub_sub = explode(',',$value->head_sub_sub);
					$sub_head_chart_of_accounts[$key]->head_sub_sub_code = explode(',',$value->head_sub_sub_code);
				}
				return view('backEnd.accounts.chart_of_account_ajax', compact('chart_of_account','sub_head_chart_of_accounts'));
		}
		
		
		public function export_excel(Request $request) {
			$chart_of_accounts = SmChartOfAccount::get();
			$excelData = [];
			foreach($chart_of_accounts as $key => $value) {
				$excelData[$key]['head_name'] = $value->head;
				$excelData[$key]['head_code'] = $value->head_code;
				$excelData[$key]['head_type'] = $value->type;
				$sub_head_chart_of_account = SmSubHeadChartOfAccount::where('head_id',$value->id)->get();
				foreach($sub_head_chart_of_account as $keysub => $valuesub) {
					$excelData[$key]['subcode'][$keysub]['head_sub'] = $valuesub->head_sub;
					$excelData[$key]['subcode'][$keysub]['head_sub_code'] = $valuesub->head_sub_code;
					$excelData[$key]['subcode'][$keysub]['head_sub_sub'] = $valuesub->head_sub_sub ? explode(',',$valuesub->head_sub_sub) : null;
					$excelData[$key]['subcode'][$keysub]['head_sub_sub_code'] = $valuesub->head_sub_sub_code ? explode(',',$valuesub->head_sub_sub_code) : null;
					
				}
			}
			$i = 0;
			$exportdata = [];
			$exportdata[$i]["Head Name"] = 'Head Name';
				$exportdata[$i]["Head Code"] = 'Head Code';
				$exportdata[$i]["Head Type"] = 'Head Type';
				$exportdata[$i]["Sub Head Name"] = 'Sub Head Name';
				$exportdata[$i]["Sub Head Code"] = 'Sub Head Code';
				$exportdata[$i]["Sub Sub Head Name"] = 'Sub Sub Head Name';
				$exportdata[$i]["Sub Sub Head Code"] = 'Sub Sub Head Code';
			$i = 1;
			foreach($excelData as $key => $value) {
				$exportdata[$i]["Head Name"] = $value['head_name'];
				$exportdata[$i]["Head Code"] = $value['head_code'];
				$exportdata[$i]["Head Type"] = $value['head_type'];
				$exportdata[$i]["Sub Head Name"] = '-';
				$exportdata[$i]["Sub Head Code"] = '-';
				$exportdata[$i]["Sub Sub Head Name"] = '-';
				$exportdata[$i]["Sub Sub Head Code"] = '-';
				if($excelData[$key]['subcode']) {
					
					foreach($excelData[$key]['subcode'] as $keysub => $valuesub) {
						$i++;
						$exportdata[$i]["Head Name"] = '-';
						$exportdata[$i]["Head Code"] = '-';
						$exportdata[$i]["Head Type"] = '-';
						$exportdata[$i]["Sub Head Name"] = $valuesub['head_sub'];
						$exportdata[$i]["Sub Head Code"] = $valuesub['head_sub_code'];
						$exportdata[$i]["Sub Sub Head Name"] = '-';
						$exportdata[$i]["Sub Sub Head Code"] = '-';
						
						
						if($valuesub['head_sub_sub']) {
							
							foreach($valuesub['head_sub_sub'] as $keysubsub => $valuesubsub) {
								$i++;
								$exportdata[$i]["Head Name"] = '-';
								$exportdata[$i]["Head Code"] = '-';
								$exportdata[$i]["Head Type"] = '-';
								$exportdata[$i]["Sub Head Name"] = '-';
								$exportdata[$i]["Sub Head Code"] = '-';
								$exportdata[$i]["Sub Sub Head Name"] = $valuesubsub;
								$exportdata[$i]["Sub Sub Head Code"] = $valuesub['head_sub_sub_code'][$keysubsub];
							}
						}
					}
				}
				$i++;
			}
			
			echo $this->array_to_csv_download($exportdata);
            die();
			
		}
		
		
		function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
			header('Content-Disposition: attachment; filename="'.$filename.'";');
			header('Content-Type: application/csv; charset=UTF-8');
			
			// open the "output" stream
			$f = fopen('php://output', 'w');
			// Write utf-8 bom to the file
			fputs($f, chr(0xEF) . chr(0xBB) . chr(0xBF));
			
			foreach ($array as $line) {
				fputcsv($f, $line, $delimiter);
			}
		} 
	}											