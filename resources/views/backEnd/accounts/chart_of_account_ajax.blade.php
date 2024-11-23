
<div class="white-box">
	<div class="add-visitor">
		<div class="row">
			<div class="col-lg-12">
				<div class="primary_input">
					<div class="row">
						<div class="col-lg-6">
							<label class="primary_input_label" for="">@lang('accounts.head_name') </label>
							{{isset($chart_of_account)? $chart_of_account->head: ''}}
						</div>
						
						<div class="col-lg-6">
							<label class="primary_input_label" for="">@lang('accounts.head_code')</label>
							{{isset($chart_of_account)? $chart_of_account->head_code: '' }}
							
						</div>
					</div>
					<?php $count = 1; ?>
					
					<div class="sub_head_panel_wrapper">
						@if(isset($chart_of_account) && count($sub_head_chart_of_accounts) > 0)
						
						@foreach($sub_head_chart_of_accounts as $sub_head_chart_of_account)
						
						<div class="sub_head_panel" style="background: blanchedalmond;margin: 30px;padding: 10px;">
							<div class="row">
								<div class="col-lg-1"></div>
								<div class="col-lg-5">
									<label class="primary_input_label" for="">@lang('accounts.sub_head_name')</label>
									{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub: ''}}
								</div>
								
								<div class="col-lg-5">
									<label class="primary_input_label" for="">@lang('accounts.sub_head_code')</label>
									{{isset($sub_head_chart_of_account)? $sub_head_chart_of_account->head_sub_code: ''}}
								</div>
							</div>
							<?php if(count($sub_head_chart_of_account->head_sub_sub) > 0 && !empty($sub_head_chart_of_account->head_sub_sub[0])) { ?>
							<div class="sub_sub_head_panel_wrapper_<?php echo $count;?>">
								<?php $subcount = 1; ?>
								
								@foreach($sub_head_chart_of_account->head_sub_sub as $key => $sub_sub_head_chart_of_account)
								<div class="sub_sub_head_panel">
									<div class="row">
										<div class="col-lg-3"></div>
										<div class="col-lg-4">
											@if($key == 0)
											<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_name')</label>
											@endif
											{{isset($sub_head_chart_of_account->head_sub_sub[$key])? $sub_head_chart_of_account->head_sub_sub[$key] : ''}}
										</div>
										
										<div class="col-lg-4">
										@if($key == 0)
											<label class="primary_input_label" for="">@lang('accounts.sub_sub_head_code')</label>
										@endif
											{{isset($sub_head_chart_of_account->head_sub_sub_code[$key])? $sub_head_chart_of_account->head_sub_sub_code[$key] : ''}}
										</div>
									</div>
								</div>
								<?php $subcount ++; ?>
								@endforeach
							</div>
							<?php } ?>
						</div>
						
						<?php
							$count++;
						?>
						@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
