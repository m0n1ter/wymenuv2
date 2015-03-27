							<?php $form=$this->beginWidget('CActiveForm', array(
									'id' => 'taste-form',
									'errorMessageCssClass' => 'help-block',
									'htmlOptions' => array(
										'class' => 'form-horizontal',
										'enctype' => 'multipart/form-data'
									),
							)); ?>
								<div class="form-body">
									<div class="form-group notSet">
										<label class="col-md-3 control-label">选择单品</label>
										<div class="col-md-4">
										<select name="ProductDiscount[product_id]" class="form-control">
										<option value="<?php echo $product->lid;?>"><?php echo $product->product_name;?></option> 
										</select>
										</div>
									</div>
									<div class="form-group">
										<?php echo $form->label($model, 'is_discount',array('class' => 'col-md-3 control-label'));?>
										<div class="col-md-4">
											<div class="radio-list">                                                
												<label class="radio-inline">
													<input type="radio" name="ProductDiscount[is_discount]" value="0"  <?php echo $model->is_discount ? '' : 'checked' ;?>/>优惠
												</label>
												<label class="radio-inline">
													<input type="radio" name="ProductDiscount[is_discount]" value="1"  <?php echo $model->is_discount ? 'checked' : '' ;?>/>折扣
												</label>  
											</div>
										</div>
									</div>
									
									<div class="form-group discount">
										<label class="col-md-3 control-label">优惠价格</label>
										<div class="col-md-2">
											<div class="input-group">
											<input type="text" class="form-control" name="ProductDiscount[price_discount]" value="<?php echo $model->price_discount;?>" /><span class="input-group-addon">元</span>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">有效期</label>
										<div class="col-md-4">
										  <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
											<input type="text" class="form-control" name="ProductDiscount[begin_time]" placeholder="开始时间" value="<?php echo $model->begin_time;?>">
											<span class="input-group-addon">~</span>
											<input type="text" class="form-control" name="ProductDiscount[end_time]" placeholder="结束时间" value="<?php echo $model->end_time;?>">
										  </div>
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-md-3 control-label">理由</label>
										<div class="col-md-4">
										  <textarea class="form-control" name="ProductDiscount[reason]"  rows="3"><?php echo $model->reason;?></textarea>
										</div>
									</div>
									
									<div class="form-actions fluid">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn blue">确定</button>
											<a href="<?php echo $this->createUrl('productSales/updatedetail' , array('companyId' => $model->dpid));?>" class="btn default">返回</a>                              
										</div>
									</div>
							<?php $this->endWidget(); ?>
							