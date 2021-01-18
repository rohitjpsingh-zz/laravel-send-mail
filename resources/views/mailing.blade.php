<!DOCTYPE html>

@extends('adminlte::page')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@stop

@section('title', 'AdminLTE')

@section('content')
<!-- Bootstrap 3.3.7 -->

@if (session('mailsuccessmsg'))
<script>
	var mailSend = 1;
</script>
@else
<script>
	var mailSend = 0;
</script>
@endif

<!-- /.col -->
<div class="col-md-12">
	<div class="card card-primary card-outline card-outline-tabs">
		<form role="form" class="form-horizontal" method="post" action="{{route('mail_submit') }}" enctype="multipart/form-data" id="mainFrm">
			<div class="card-header p-0 pt-1 border-bottom-0">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item"><a class="nav-link active" href="#mailing" data-toggle="pill">Mailing</a></li>
					<li class="nav-item"><a class="nav-link" href="#content" id="content_data" data-toggle="pill">Content</a></li>
					<li class="nav-item"><a class="nav-link" href="#PictureComponents" data-toggle="pill">Picture Components</a></li>
					<li class="nav-item"><a class="nav-link" href="#attachments" data-toggle="pill">Attachments</a></li>
					<li class="nav-item"><a class="nav-link" href="#trackabelLinks" data-toggle="pill">Trackabel Links</a></li>
					<li class="nav-item"><a class="nav-link" href="#sendMailing" data-toggle="pill">Send Mailing</a></li>
					<li class="nav-item"><a class="nav-link" href="#statistics" data-toggle="pill">Statistics</a></li>
					<li class="nav-item"><a class="nav-link" href="#reports" data-toggle="pill">Reports </a></li>
					<li class="nav-item ml-auto">
						<button type="button" onclick="$('#mainFrm').submit()" class="btn btn-primary ml-2 mr-2">Save</button>
					</li>
				</ul>
			</div><!-- /.card-header -->
			<div class="card-body">
				@if (session('mailsuccessmsg'))
				<div class="alert alert-success">
					{{ session('mailsuccessmsg') }}
				</div>
				@endif

				{{ csrf_field() }}
				<div class="tab-content">
					<div class="active tab-pane" id="mailing">
						<div class="card card-primary card-outline">
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="email" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-10">
												<input type="text" name="email" class="form-control" id="email" placeholder="Enter Email Campaign">
												@if($errors->has('email'))
												<div class="text-danger">{{ $errors->first('email') }}</div>
												@endif
											</div>
										</div>
									</div>
									<!-- /.col -->
									<div class="col-md-8">
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Description(Optional)</label>
											<div class="col-sm-8">
												<textarea class="form-control description" name="description" id="description" rows="3" placeholder="Enter ..."></textarea>
												<!-- @if($errors->has('description'))
		                                    <div class="text-danger">{{ $errors->first('description') }}</div>
		                                    @endif -->
											</div>
										</div>
									</div>
									<!-- /.col -->
								</div>
							</div>
						</div>
						<!-- /.row -->

						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<i class="fa fa-envelope"></i> <span>Mailbox</span>
								<!-- /.box-header -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="subject">Subject:</label>
											<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
											@if($errors->has('subject'))
											<div class="text-danger">{{ $errors->first('subject') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="sender_email">Sender email:</label>
											<input type="text" class="form-control" name="sender_email" id="sender_email" placeholder="Sender Email">
											@if($errors->has('sender_email'))
											<div class="text-danger">{{ $errors->first('sender_email') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="sender_fullname">Sender full name:</label>
											<input type="text" class="form-control" name="sender_fullname" id="sender_fullname" placeholder="Sender full name">
											@if($errors->has('sender_fullname'))
											<div class="text-danger">{{ $errors->first('sender_fullname') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="reply_to_email">Reply-to email:</label>
											<input type="text" class="form-control" name="reply_to_email" id="reply_to_email" placeholder="Reply-to email">

										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="reply_to_fullname">Reply-to full name:</label>
											<input type="text" class="form-control" name="reply_to_fullname" id="reply_to_fullname" placeholder="Reply-to full name">

										</div>
									</div>
									<!-- /.col -->
									<div class="col-md-6">
										<div class="form-group">
											<label for="charset">Charset:</label>
											<select class="form-control" name="charset" id="charset">
												<option selected>Unicode (UTF-8)</option>
												<option>ISO 8859-15</option>
												<option>ISO 8859-1</option>
												<option>Chinese simplified(GB2312)</option>
											</select>
											@if($errors->has('charset'))
											<div class="text-danger">{{ $errors->first('charset') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="line_feed_after">Line feed after:</label>
											<select class="form-control" name="line_feed_after" id="line_feed_after">
												<option selected>No line feed</option>
												<?php
												for ($i = 60; $i <= 100; $i++) {
													echo "<option value=" . $i . ">" . $i . " characters</option>";
												}

												?>
											</select>
											@if($errors->has('line_feed_after'))
											<div class="text-danger">{{ $errors->first('line_feed_after') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="format">Format:</label>
											<select class="form-control" name="format" id="format">
												<option selected>Text,HTML and offline HTML</option>
												<option>Only text</option>
												<option>Text and HTML</option>
											</select>
											@if($errors->has('format'))
											<div class="text-danger">{{ $errors->first('format') }}</div>
											@endif
										</div>
										<!-- /.col -->
										<div class="form-group">
											<label for="measure_open_rate">Measure open rate:</label>
											<select class="form-control" name="measure_open_rate" id="measure_open_rate">
												<option selected>at top of email</option>
												<option>at bottom of email</option>
												<option>No</option>
											</select>
											@if($errors->has('measure_open_rate'))
											<div class="text-danger">{{ $errors->first('measure_open_rate') }}</div>
											@endif
										</div>
										<!-- /.col -->

									</div>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<!-- /.box-header -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile" id="accordion">
								<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
								<div class="box-header with-border">
									<h6 class="box-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
											<i class="fa fa-file"></i> <span><u> Show template </u></span>
										</a>
									</h6>
								</div>
								<div id="collapseOne" class="panel-collapse collapse">
									<div class="box-body">
										Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
										wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
										eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
										assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
										nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
										farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
										labore sustainable VHS.
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
						<label>Settings:</label>
						<!-- /.box-header -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile" id="accordion1">
								<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
								<div class="box-header with-border">
									<h6 class="box-title">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
											<i class="fa fa-angle-double-right"></i> <span><u>General </u></span>
										</a>
									</h6>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="box-body">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="email" class="col-sm-4 control-label">Template:</label>
													<input type="text" class="form-control" name="template" id="template" placeholder="Enter email">
												</div>
												<!-- /.col -->
												<div class="form-group">
													<label for="mailing_list" class="col-sm-4 control-label">Mailing List:</label>
													<select class="form-control" name="mailing_list" id="mailing_list" onchange="get_email_campaign()">
														<option value="" selected="selected">Select broadcastname</option>
														@foreach($broadcast_name as $single_data)
														<option value="{{$single_data->id}}">{{$single_data->broadcast_name}}</option>
														@endforeach
													</select>
													@if($errors->has('mailing_list'))
													<div class="text-danger">{{ $errors->first('mailing_list') }}</div>
													@endif
												</div>
												<!-- /.col -->
												<div class="form-group">
													<label for="get_email_cmpgn" class="col-sm-4 control-label">Email campaign:</label>
													<select class="select2bs4" multiple="multiple" data-placeholder="Select a Email" name="get_email_cmpgn[]" id="get_email_cmpgn">

													</select>
												</div>

											</div>
											<!-- /.col -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="archive" class="col-sm-4 control-label">Archive:</label>
													<select class="form-control" name="archive" id="archive">
														<option selected>no archiive</option>
														<option>at bottom of email</option>
														<option>No</option>
													</select>
													<input type="checkbox" name="show_archive" id="show_archive" value="1">Show in archive
												</div>
												<!-- /.col -->
												<div class="form-group">
													<label for="mailing_type" class="col-sm-4 control-label">Mailing Type:</label>
													<select class="form-control" name="mailing_type" id="mailing_type">
														<option selected>Normal mailing</option>
														<option>Action based mailing</option>
														<option>Date based mailing</option>
													</select>
												</div>
											</div>
											<!-- /.col -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box-body -->


					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="content">
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="email_campaign" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-10">
												<input type="text" class="form-control email_campaign" id="email_campaign1" placeholder="Enter Email Campaign" disabled="disabled">
											</div>
										</div>
									</div>
									<!-- /.col -->
									<div class="col-md-8">
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Description(Optional)</label>
											<div class="col-sm-9">
												<textarea class="form-control description" rows="3" id="description1" placeholder="Enter ..." disabled="disabled"></textarea>
											</div>
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="row">
									<div class="col-md-3">
										<label>Recipients</label>
										<select class="form-control">
											<option selected disabled></option>
											<option>option 1</option>
											<option>option 2</option>
											<option>option 3</option>
											<option>option 4</option>
											<option>option 5</option>
										</select>
									</div>
									<div class="col-md-2">
										<label>Format:</label>
										<select class="form-control">
											<option selected disabled>HTML</option>
											<option>option 1</option>
											<option>option 2</option>
											<option>option 3</option>
											<option>option 4</option>
											<option>option 5</option>
										</select>
									</div>
									<div class="col-md-3">
										<label>Text Disabled</label>
										<select class="form-control">
											<option selected disabled>800*600</option>
											<option>option 1</option>
											<option>option 2</option>
											<option>option 3</option>
											<option>option 4</option>
											<option>option 5</option>
										</select>
									</div>

									<div class="col-md-2">
										<label></label></br>
										No Images:
										<input type="checkbox" class="minimal">
									</div>
									<div class="col-md-2">
										<label></label>
										<button type="button" class="btn btn-block btn-primary">Preview</button>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<!-- /.box-header -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<table class="table table-bordered">
									<tr>
										<th>Text Module</th>
										<th>Target Group</th>
										<th>Content</th>
									</tr>
									<tr>
										<td>HTML-version</td>
										<td>All Subscribers</td>
										<td>html,read</td>
									</tr>
									<tr>
										<td></td>
										<td>New Content</td>
										<td></td>
									</tr>
									<tr>
										<td>Text</td>
										<td>All Subscribers</td>
										<td>TATA AIA Regards, Customer Serve</td>
									</tr>
									<tr>
										<td></td>
										<td>New Content</td>
										<td></td>
									</tr>
								</table>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane" id="PictureComponents">
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-10">
												<input type="text" class="form-control email_campaign" id="email_campaign2" placeholder="Enter Email Campaign" disabled="disabled">
											</div>
										</div>
									</div>
									<!-- /.col -->
									<div class="col-md-8">
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Description(Optional)</label>
											<div class="col-sm-9">
												<textarea class="form-control description" rows="3" placeholder="Enter ..." id="description2" disabled="disabled"></textarea>
											</div>
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<!-- Main content -->
						<section class="content">
							<div class="row">
								<div class="col-md-12">
									<div class="card card-outline card-info">

										<!-- /.card-header -->
										<div class="card-body pad">
											<div class="mb-3">
												<textarea class="form-control editor_text" id="editor_text" name="editor_text" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
												@if($errors->has('editor_text'))
												<div class="text-danger">{{ $errors->first('editor_text') }}</div>
												@endif
											</div>

										</div>
									</div>
								</div>
								<!-- /.col-->
							</div>
							<!-- ./row -->
						</section>
						<!-- /.content -->
					</div>

					<div class="tab-pane" id="attachments">
					</div>

					<div class="tab-pane" id="trackabelLinks">
					</div>

					<div class="tab-pane sendMailing" id="sendMailing">
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="email" class="col-sm-3 control-label">Email</label>
											<div class="col-sm-10">
												<input type="text" class="form-control email_campaign" id="email_campaign3" placeholder="Enter Email Campaign" disabled="disabled">
											</div>
										</div>
									</div>
									<!-- /.col -->
									<div class="col-md-8">
										<div class="form-group">
											<label for="description" class="col-sm-4 control-label">Description(Optional)</label>
											<div class="col-sm-9">
												<textarea class="form-control description" id="description3" rows="3" placeholder="Enter ..." disabled="disabled"></textarea>
											</div>
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="row">
									<div class="col-md-2">
										Preview of mailing
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-block btn-primary">Preview</button></br>
									</div>
								</div>
								This Mailing was already sent.<br>
								You can send test versions of this mailing again,<br>
								e.g.for archive purposes.For safety reasons,<br>
								another sending of this mailing to all recipients is not allowed.</br>
								<!-- /.col -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<div class="card card-primary card-outline">
							<div class="card-header">
								Delivery Time
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label"></label>
									<div class="col-sm-10">
										<input type="checkbox" name="has_email_cron" value="yes" {{ (old('has_email_cron') == 'yes') ? ' checked' : '' }}> Send Email At Schedule Time
									</div>
								</div>
								<div class="form-group row">
									<label for="staticEmail" class="col-sm-2 col-form-label">Date</label>
									<div class="col-sm-10">
										<input type="text" onkeyup="$(this).val('')" name="delivery_date" class="form-control" id="datepicker" value="{{ (old('delivery_date')) ? old('delivery_date') : '' }}">
										@if($errors->has('delivery_date'))
										<div class="text-danger">{{ $errors->first('delivery_date') }}</div>
										@endif
									</div>
								</div>
								<div class="form-group row">
									<label for="inputPassword" class="col-sm-2 col-form-label">Time</label>
									<div class="col-sm-5">
										<select class="form-control" id="time_hour_txt" name="delivery_time_hour">
											<option value="">Hour</option>
											<?php
											$start = 1;
											$end = 24;
											for ($time = $start; $time <= $end; $time++) {
												echo "<option value=" . date("H", mktime($time)) . ">" . date("H", mktime($time)) . "</option>";
											}
											?>
										</select>
										@if($errors->has('delivery_time_hour'))
										<div class="text-danger">{{ $errors->first('delivery_time_hour') }}</div>
										@endif
									</div>
									<div class="col-sm-5">
										<select class="form-control" id="time_minute_txt" name="delivery_time_minute">
											<option value="">Minute</option>
											<?php
											$start = 00;
											$end = 59;
											for ($time = $start; $time <= $end; $time++) {
												$temp = str_pad($time, 2, "0", STR_PAD_LEFT);
												echo "<option value=" . $temp . ">" . $temp . "</option>";
											}
											?>
										</select>
										@if($errors->has('delivery_time_minute'))
										<div class="text-danger">{{ $errors->first('delivery_time_minute') }}</div>
										@endif
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<!-- iCheck -->
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<!-- Minimal style -->
								<div class="row">
									<div class="col-xs-2">
										Check links:
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-block btn-primary">Check</button>
									</div>
									<div class="col-xs-2">
										Admin-Mail:
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-block btn-primary">Send</button>
									</div>
									<div class="col-xs-2">
										Test Mail:
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-block btn-primary">Send</button>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->

						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<h3 class="card-title"><b>Distribution Status:</b>This mail has already been sent.</h3>
							</div>
							<div class="row">
								<!-- /.box-header -->
								<div class="card-body">
									<table class="table table-bordered">
										<tr>
											<th>Last delivery</th>
											<th>World delivery</th>
										</tr>
										<tr>
											<td>Date</td>
											<td><?php echo date('d-m-Y', strtotime($reports->date)); ?></td>
										</tr>
										<tr>
											<td>Time</td>
											<td><?php echo date('H:i:s', strtotime($reports->date)); ?></td>
										</tr>
										<tr>
											<td>Target groups</td>
											<td><?php echo $reports->bName; ?></td>
										</tr>
										<tr>
											<td>Total emails</td>
											<td><?php echo $reports->total_mail; ?></td>
										</tr>
									</table>
								</div>
								<!-- /.box-body -->

								<!-- /.box-header -->
								<div class="card-body">
									<table class="table table-bordered">
										<tr>
											<th>Generation</th>
											<th></th>
										</tr>
										<tr>
											<td>Started</td>
											<td><?php echo date('d-m-Y H:i:s', strtotime($reports->start_time)); ?></td>
										</tr>
										<tr>
											<td>Ended</td>
											<td><?php echo date('d-m-Y H:i:s', strtotime($reports->end_time)); ?></td>
										</tr>
										<tr>
											<td>Generated emails</td>
											<td><?php echo $reports->total_mail; ?></td>
										</tr>
									</table>
								</div>
								<!-- /.box-body -->

								<!-- /.box-header -->
								<div class="card-body">
									<table class="table table-bordered">
										<tr>
											<th>Delivery</th>
											<th></th>
										</tr>
										<tr>
											<td>Started</td>
											<td><?php echo date('d-m-Y H:i:s', strtotime($reports->start_time)); ?></td>
										</tr>
										<tr>
											<td>Ended</td>
											<td><?php echo date('d-m-Y H:i:s', strtotime($reports->end_time)); ?></td>
										</tr>
										<tr>
											<td>Emails sent</td>
											<td><?php echo $reports->total_mail; ?></td>
										</tr>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.tab-pane -->

					<div class="tab-pane" id="statistics">
						<div class="box box-success">
							<div class="card-body">
								<!-- Minimal style -->
								<div class="row">
									<div class="col-md-2">
										<button type="button" class="btn btn-block btn-primary">Heatmap</button></br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Target group:</label>
											<select class="form-control">
												<option selected disabled>All Subscribers</option>
												<option>option 1</option>
												<option>option 2</option>
												<option>option 3</option>
												<option>option 4</option>
												<option>option 5</option>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<label></label>
										<button type="button" class="btn btn-block btn-primary">Add</button>
									</div>
								</div>
								<!-- /.col -->

								<!-- Table row -->
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>URL</th>
													<th></th>
													<th></th>
													<th></th>
													<th>Click gross(net)All Subscribers</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Total clicking subscribers:</td>
													<td></td>
													<td></td>
													<td></td>
													<td>0 (0%)</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
												<tr>
													<td><b><u>total clicks:</u></b></td>
													<td></td>
													<td></td>
													<td></td>
													<td>0 (0)</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->

								<!-- Table row -->
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Delivery Statistics:</th>
													<th></th>
													<th></th>
													<th></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><b><u>Opened mails:</u></b></td>
													<td></td>
													<td></td>
													<td></td>
													<td>0 (0%)</td>
												</tr>
												<tr>
													<td>Opt-Outs:</td>
													<td></td>
													<td></td>
													<td></td>
													<td>0 (0%)</td>
												</tr>
												<tr>
													<td><b><u>Bounces:</u></b></td>
													<td></td>
													<td></td>
													<td></td>
													<td>0 (0%)</td>
												</tr>
												<hr>
												<tr>
													<td><b>Recipients:</b></td>
													<td></td>
													<td></td>
													<td></td>
													<td>49998</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->


							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>

					<!-- /.tab-pane -->

					<div class="tab-pane" id="reports">
						<div class="box box-success">
							<div class="card-body">
								<!-- Table row -->
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>Sr. No</th>
													<th>Email</th>
													<th>Subject</th>
													<th>Sender Email</th>
													<th>Sender Full Name</th>
													<th>Has Schedule</th>
													<th>Created Date</th>
													<th colspan="2"></th>
												</tr>
											</thead>
											<tbody>

												@if($send_mail_contents && count($send_mail_contents) > 0)
												@foreach($send_mail_contents as $key => $mail)
												<tr>
													<td>{{$key+1}}</td>
													<td>{{ $mail->email }}</td>
													<td>{{ $mail->subject }}</td>
													<td>{{ $mail->sender_email }}</td>
													<td>{{ $mail->sender_fullname }}</td>
													<td>{{ ($mail->has_email_cron) ? 'Yes' : 'No' }}</td>
													<td>{{ \Carbon\Carbon::parse($mail->created_at)->diffForHumans() }}</td>
													<td>
														<a href="#" data-toggle="modal" data-target="#view_template_{{$mail->id}}" class="fa fa-eye"></a> &nbsp;&nbsp;
														<a href="#" data-toggle="modal" data-target="#view_template_mail_{{$mail->id}}" class="fa fa-envelope"></a>

														<div class="modal fade" id="view_template_{{$mail->id}}">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Sent Mail Detail</h4>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-xs-12 table-responsive">
																				<table class="table table-striped">
																					<tbody>
																						<tr>
																							<th>Sr. No</th>
																							<td>{{$key+1}}</td>
																						</tr>
																						<tr>
																							<th>Email</th>
																							<td>{{ $mail->email }}</td>
																						</tr>
																						<tr>
																							<th>Subject</th>
																							<td>{{ $mail->subject }}</td>
																						</tr>
																						<tr>
																							<th>Description</th>
																							<td>{{ $mail->description }}</td>
																						</tr>
																						<tr>
																							<th>Sender Email</th>
																							<td>{{ $mail->sender_email }}</td>
																						</tr>
																						<tr>
																							<th>Sender Full Name</th>
																							<td>{{ $mail->sender_fullname }}</td>
																						</tr>
																						<tr>
																							<th>Reply To Email</th>
																							<td>{{ $mail->reply_to_email }}</td>
																						</tr>
																						<tr>
																							<th>Reply To Full Name</th>
																							<td>{{ $mail->reply_to_fullname }}</td>
																						</tr>
																						<tr>
																							<th>Charset</th>
																							<td>{{ $mail->charset }}</td>
																						</tr>
																						<tr>
																							<th>Line Feed After</th>
																							<td>{{ $mail->line_feed_after }}</td>
																						</tr>
																						<tr>
																							<th>Format</th>
																							<td>{{ $mail->format }}</td>
																						</tr>
																						<tr>
																							<th>Measure Open Rate</th>
																							<td>{{ $mail->measure_open_rate }}</td>
																						</tr>

																						<tr>
																							<th>Template</th>
																							<td>{{ $mail->template }}</td>
																						</tr>
																						<tr>
																							<th>Broadcast Name</th>
																							<td>{{ $mail->broadcast_name }}</td>
																						</tr>

																						<tr>
																							<th>Archieve</th>
																							<td>{{ $mail->archive }}</td>
																						</tr>

																						<tr>
																							<th>Show Archieve</th>
																							<td>{{ ($mail->show_archive) ? "Yes" : "No" }}</td>
																						</tr>

																						<tr>
																							<th>Mailing Type</th>
																							<td>{{ $mail->mailing_type }}</td>
																						</tr>

																						<tr>
																							<th>Editor Text</th>
																							<td>{!! $mail->editor_text !!}</td>
																						</tr>

																						<tr>
																							<th>Has Scheduled</th>
																							<td>{{ ($mail->has_email_cron) ? 'Yes' : 'No' }}</td>
																						</tr>

																						<tr>
																							<th>Delivery Date</th>
																							<td>{{ ($mail->delivery_date) ? $mail->delivery_date : '-' }}</td>
																						</tr>

																						<tr>
																							<th>Delivery Time</th>
																							<td>{{ (($mail->delivery_time_hour) ? $mail->delivery_time_hour.':' : '-').$mail->delivery_time_minute }}</td>
																						</tr>
																						<tr>
																							<th>Created Date</th>
																							<td>{{ $mail->created_at }}</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer justify-content-between">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
														<!-- /.modal -->


														<div class="modal fade" id="view_template_mail_{{$mail->id}}">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Sent Mail List</h4>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-xs-12 table-responsive">
																				<table class="table table-striped">

																					<tbody>
																						<tr>
																							<th>Email</th>
																							<th>Status</th>
																						</tr>
																						@if($send_mail_contents && count($mail->sent_mail_list) > 0)
																						@foreach($mail->sent_mail_list as $key => $email)
																						<tr>
																							<td>{{$email->email_address}}</td>
																							<td>{{($email->status) ? 'Sent' : 'Pending'}}</td>
																						</tr>
																						@endforeach
																						@endif
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																	<div class="modal-footer justify-content-between">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
														<!-- /.modal -->
													</td>
												</tr>
												@endforeach
												@endif
											</tbody>
										</table>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>

				<!-- /.tab-content -->
			</div><!-- /.card-body -->
		</form>
	</div>
	<!-- /.nav-tabs-custom -->
</div>
<!-- /.col -->
<!-- /.col -->



@stop


@section('js')
<script type="text/javascript">
	$('#content_data').on('click', function(event) {

		var email = $('#email').val();
		var description = $('#description').val();

		if (email != '' || description != '') {
			$(".email_campaign").val(email);
			$(".description").val(description);
		} else {
			$(".email_campaign").val("");
			$(".description").val("");
		}
	});
</script>

<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Select2 -->
<script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

<!-- bootstrap datepicker -->
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
	$('.editor_text').summernote({
		placeholder: 'Enter...',
		height: 300,
		onImageUpload: function(files, editor, $editable) {
			sendFile(files[0], editor, $editable);
		}
	});

	//Date picker
	$('#datepicker').datepicker({
		todayHighlight: true,
		autoclose: true,
		format: 'yyyy-mm-dd',
		startDate: new Date(),
	})
</script>
<script type="text/javascript">
	$('document').ready(function() {
		$('.note-group-image-url').css('display', 'none');

	});

	if (mailSend == 1) {
		$('.card .nav-tabs .nav-item .nav-link').removeClass('active');
		$('[href*="sendMailing"]').trigger('click');
	}

	/*function sendMailreport(){
		alert('hy');
	}*/


	function get_email_campaign() {
		var bid = $("#mailing_list").val();
		$.ajax({
			url: "{{ url('get-email-by-name') }}",
			method: 'POST',
			data: {
				"_token": "{{ csrf_token() }}",
				"bid": bid,
			},
			success: function(data) {

				data = JSON.parse(data);
				var sel = $("#get_email_cmpgn");

				sel.empty();
				$.each(data, function(key, value) {

					sel.append('<option value="' + value['email'] + '">' + value['email'] + '</option>')
				});
			}
		});
	}

	//Initialize Select2 Elements
	$('.select2').select2()

	//Initialize Select2 Elements
	$('.select2bs4').select2({
		theme: 'bootstrap4'
	})
</script>
@stop