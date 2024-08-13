<?php include("includes/dashboard_header.php");?>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Users</h2>
            </div>
          </header>
		  <?php if(isset($_GET['user'])){
				$user_id = clean(base64_url_decode($_GET['user']));
				$userQ = $conex->query("SELECT * FROM users WHERE REF_ID = '$user_id'");
				$user_rows = $userQ->num_rows;
				if($user_rows == 0){
					header("Location:user-list");
					exit;
				}else{
					$userData = $userQ->fetch_assoc();
					$userCode = $userData['CODE'];
					$sponsor = $userData['REFFERED_USER'];
					$sponsorQ = $conex->query("SELECT * FROM users WHERE CODE = '$sponsor'");
					$sponsor_data = $sponsorQ->fetch_assoc();
					$get_amount = get_binary_commission($conex, $userCode)+ get_refferal_commission($conex, $userCode) + get_rank_reward($conex, $userCode) + get_total_roi($conex, $userCode) + received_transfered_fund($conex, $userCode);
					$spent_amount = ew_buy_plans($conex, $userCode) + send_transfered_fund($conex, $userCode) + total_withdraw($conex, $userCode);
					$e_wallet = $get_amount - $spent_amount;
				}
				if(!empty($sponsor)){
		?>
		    <section class="tables pt-2">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Sponsor</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-md">
                          <thead>
                            <tr>
                              <th>USER ID</th>
                              <th>NAME</th>
                              <th>RIGHT</th>
                              <th>LEFT</th>
                              <th>STATUS</th>
                            </tr>
                          </thead>
                          <tbody>
								<tr>
									<td><?=$sponsor_data['REF_ID'];?></td>
									<td><?=$sponsor_data['FIRST_NAME'].' '.$sponsor_data['LAST_NAME'];?></td>
									<td><?=down_liner_invest($conex, down_liner_left($conex, $sponsor)['members'])['ins'];?> <strong>$</strong></td>
									<td><?=down_liner_invest($conex, down_liner_right($conex, $sponsor)['members'])['ins'];?> <strong>$</strong></td>
									<td><?=get_status($sponsor_data['STATUS']);?></td>
								</tr>
										
							</tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		<?php } ?>
			<section class="dashboard-counts no-padding-bottom pt-3">
            <div class="container-fluid">
              <div class="row p-0">
                <!-- Item -->
                <div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-wallet"></i></div>
                    <div class="text"><strong><?=number_format($e_wallet,4);?>$</strong><br><small>E-Wallet</small></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-money-check-alt"></i></div>
                    <div class="text"><strong><?=my_invest($conex, $userCode);?>$</strong><br><small>Investment</small></div>
                  </div>
                </div>
				<div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-chart-line"></i></div>
                    <div class="text"><strong><?=ucwords(my_rank($conex, $userCode)['name']);?></strong><br><small>Rank</small></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row p-0">
                <!-- Item -->
                <div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-money-bill-alt"></i></div>
                    <div class="text"><strong><?=get_binary_commission($conex, $userCode);?>$</strong><br><small>Binary Commission</small></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="text"><strong><?=get_refferal_commission($conex, $userCode);?>$</strong><br><small>Refferal Commission</small></div>
                  </div>
                </div>
				<div class="col-sm-4 mb-3">
                  <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <div class="text"><strong><?=get_total_roi($conex, $userCode);?>$</strong><br><small>ROI</small></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  <ul class="nav nav-pills nav-justified mt-3 mx-4" style="background-color:#000;border-radius:1.25rem;">
				<li class="nav-item"><a data-toggle="tab"  class="nav-link active" href="#binary_tree">Binary Tree</a></li>
				<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#refferals">Refferal</a></li>
				<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#binary">Binary</a></li>
			</ul>
			<div class="tab-content">
			<section class="tables pt-3 tab-pane fade show active" id="binary_tree">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                      <div class="card-header">
                        <form class="form-inline float-left">
                              <input type="text" class="form-control float-left" id="downliner" placeholder="Find Your Downliner">
                              <button type="submit" class="btn btn-primary" id="downliner_btn"  user-data="<?=SA_Encryption::encrypt_to_url_param($userCode);?>">Search</button>
                            </form>
                      <button class="p-1 btn float-right ref_img_active" style="width:auto;height:auto;"  user-data="<?=SA_Encryption::encrypt_to_url_param($userCode);?>"><i class="fas fa-arrow-circle-left"></i> Back</button>
                    </div>
                    <div class="card-body" id="binary_tree_id">
						<?php
							$binQ = $conex->query("SELECT * FROM user_tree WHERE USER_CODE = '$userCode'");
							$bin_data = $binQ->fetch_assoc();
							$f_Left = $bin_data['LEFT_SIDE']; 
							$f_Right = $bin_data['RIGHT_SIDE'];
						?>
						<div class="row my-3">
							<div class="col">
								<div class="tree_cont">
									<img src="images/yes_user.png" class="ref_img_active d-block mx-auto" user-data="<?=SA_Encryption::encrypt_to_url_param($userCode);?>">
									<p><?=$userData['REF_ID'];?></p>
									<?=get_tree_user_data($conex, $userCode);?>
								</div>
							</div>
						</div>
						<div class="row my-3 main_tree">
							<div class="col first_child_tree">
								<div class="tree_cont">
									<img src="images/<?=((empty($f_Left))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Left))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Left))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Left).'"');?>>
									<p><?=((empty($f_Left))?'NO USER':single_user_data($conex, $f_Left)['REF_ID']);?></p>
									<?=((empty($f_Left))?'<span></span>':get_tree_user_data($conex, $f_Left));?>
								</div>
							</div>
							<div class="col first_child_tree">
								<div class="tree_cont">
									<img src="images/<?=((empty($f_Right))?'no_user.png':'yes_user.png');?>" class="<?=((empty($f_Right))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($f_Right))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($f_Right).'"');?>>
									<p><?=((empty($f_Right))?'NO USER':single_user_data($conex, $f_Right)['REF_ID']);?></p>
									<?=((empty($f_Right))?'<span></span>':get_tree_user_data($conex, $f_Right));?>
								</div>
							</div>
						</div>
						<div class="row my-3 sub_tree">
							<div class="col first_child_tree">
								<div class="tree_cont">
									<?php
										$first = get_binary_users($conex, $f_Left)['LEFTY'];
									?>
									<img src="images/<?=((empty($first))?'no_user.png':'yes_user.png');?>" class="<?=((empty($first))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($first))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($first).'"');?>>
									<p><?=((empty($first))?'NO USER':single_user_data($conex, $first)['REF_ID']);?></p>
									<?=((empty($first))?'<span></span>':get_tree_user_data($conex, $first));?>
								</div>
							</div>
							<div class="col first_child_tree">
								<div class="tree_cont">
									<?php
										$second = get_binary_users($conex, $f_Left)['RIGHTY'];
									?>
									<img src="images/<?=((empty($second))?'no_user.png':'yes_user.png');?>" class="<?=((empty($second))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($second))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($second).'"');?>>
									<p><?=((empty($second))?'NO USER':single_user_data($conex, $second)['REF_ID']);?></p>
									<?=((empty($second))?'<span></span>':get_tree_user_data($conex, $second));?>
								</div>
							</div>
							<div class="col first_child_tree">
								<div class="tree_cont">
									<?php
										$third = get_binary_users($conex, $f_Right)['LEFTY'];
									?>
									<img src="images/<?=((empty($third))?'no_user.png':'yes_user.png');?>" class="<?=((empty($third))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($third))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($third).'"');?>>
									<p><?=((empty($third))?'NO USER':single_user_data($conex, $third)['REF_ID']);?></p>
									<?=((empty($third))?'<span></span>':get_tree_user_data($conex, $third));?>
								</div>
							</div>
							<div class="col first_child_tree">
								<div class="tree_cont">
									<?php
										$four = get_binary_users($conex, $f_Right)['RIGHTY'];
									?>
									<img src="images/<?=((empty($four))?'no_user.png':'yes_user.png');?>" class="<?=((empty($four))?'ref_img_inactive':'ref_img_active');?> d-block mx-auto" <?=((empty($four))?'':'user-data="'.SA_Encryption::encrypt_to_url_param($four).'"');?>>
									<p><?=((empty($four))?'NO USER':single_user_data($conex, $four)['REF_ID']);?></p>
									<?=((empty($four))?'<span></span>':get_tree_user_data($conex, $four));?>
								</div>
							</div>
						</div>
						<div id="wait_tree">
							<div class="row h-100 justify-content-center align-items-center">
								<div class="col-12">
								  <img src="images/spinner.gif" class="d-block mx-auto">
								</div>   
							  </div>
						</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  <section class="tables pt-3 tab-pane fade" id="refferals">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="h4">Refferals</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-md" id="my_table">
                          <thead>
                            <tr>
                              <th>AMOUNT</th>
                              <th>COMMISSION</th>
                              <th>DATE</th>
                              <th>STATUS</th>
                            </tr>
                          </thead>
                          <tbody>
							<?php
								$sql = $conex->query("SELECT * FROM referral_commission_view WHERE USER_CODE = '$userCode'");
								while($ref_data = $sql->fetch_assoc()){
							?>
                            <tr>
								<td><?=$ref_data['AMOUNT'];?></td>
								<td><?=$ref_data['COMMISSION'];?> <strong>$</strong></td>
								<td><?=date('Y-m-d', strtotime($ref_data['DATE_TIME']));?></td>
								<td><?=($ref_data['STATUS'] == 1)?'Released':'Hold';?></td>
                            </tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  <section class="tables pt-3 tab-pane fade" id="binary">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="h4">Binary</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-md" id="my_table2">
                          <thead>
                            <tr>
                              <th>AMOUNT</th>
                              <th>COMMISSION</th>
                              <th>DATE</th>
                              <th>STATUS</th>
                            </tr>
                          </thead>
                          <tbody>
							<?php
								$sql = $conex->query("SELECT * FROM binary_commission_view WHERE USER_CODE = '$userCode'");
								while($ref_data = $sql->fetch_assoc()){
							?>
                            <tr>
								<td><?=$ref_data['AMOUNT'];?></td>
								<td><?=$ref_data['COMMISSION'];?> <strong>$</strong></td>
								<td><?=date('Y-m-d', strtotime($ref_data['DATE_TIME']));?></td>
								<td><?=($ref_data['STATUS'] == 1)?'Released':'Hold';?></td>
                            </tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  </div>
		  <?php }else{ ?>
		   <section class="tables pt-3" id="refferals">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
				<?php include("includes/msg.php"); ?>
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Users List</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive d-block d-sm-table">
                        <table class="table table-md" id="my_table">
                          <thead>
                            <tr>
                              <th>USER ID</th>
                              <th>NAME</th>
                              <th>LEFT</th>
                              <th>RIGHT</th>
                              <th>STATUS</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							<?php
								$sql = $conex->query("SELECT * FROM users WHERE TYPE = 'USER' AND STATUS IN (1, 2, 3, 4) ORDER BY JOIN_DATE DESC");
								while($U_data = $sql->fetch_assoc()){
							?>
							<tr>
								<td><?=$U_data['REF_ID'];?></td>
								<td><?=$U_data['FIRST_NAME'].' '.$U_data['LAST_NAME'];?></td>
								<td><?=down_liner_invest($conex, down_liner_left($conex, $U_data['CODE'])['members'])['ins'];?> <strong>$</strong></td>
								<td><?=down_liner_invest($conex, down_liner_right($conex, $U_data['CODE'])['members'])['ins'];?> <strong>$</strong></td>
								<td><button class="btn"><?=get_status($U_data['STATUS']);?></button></td>
								<td>
									<ul class="action_list">
										<li><a href="#"><i class="fas fa-ellipsis-h"></i></a></li>
										<ul class="actions">
											<li><a href="user-list?user=<?=base64_url_encode($U_data['REF_ID']);?>" id="<?=SA_Encryption::encrypt_to_url_param($U_data['CODE']);?>">Details</a></li>
											<?php if($U_data['STATUS'] == 1){ ?>
											<li><a href="#" id="<?=SA_Encryption::encrypt_to_url_param($U_data['CODE']);?>" class="user_blcok">Block</a></li>
											<?php }elseif($U_data['STATUS'] == 0){ ?>
											<li><a href="#" id="<?=SA_Encryption::encrypt_to_url_param($U_data['CODE']);?>" class="user_del">Delete</a></li>
											<?php }elseif($U_data['STATUS'] == 2){ ?>
											<li><a href="#" id="<?=SA_Encryption::encrypt_to_url_param($U_data['CODE']);?>" class="user_active">Active</a></li>
											<?php } ?>
										</ul>
									</ul>
								</td>
							</tr>
							<?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
<?php include("includes/dashboard_footer.php");?>
<script>
	$(".action_list > li > a").blur(function(event){
		event.preventDefault();
		$(this).parent().next().stop().fadeOut();
	});
	$(".action_list > li > a").click(function(event){
		event.preventDefault();
		$(this).parent().next().stop().fadeToggle();
	});
	// BLOCK USER
	$(document).on("click", '.user_blcok',function(e){
		e.preventDefault();
		var block_code = $(this).attr("id");
		swal({
		  title: "Are you sure?",
		  text: "You want to block this user!",
		  icon: "warning",
		  buttons: {
			cancel: "Cancel",
			catch: {
			  text: "Block",
			  value: "catch",
			},
		  },
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			  $.ajax({
				  url:"ajax_files/user_deal.php",
				  method:"post",
				  data:{block_code:block_code},
				  success:function(msg){
					  if(msg == 'success'){
						  swal({
							  text:"Success! User has been Blocked!",
							  icon: "success"
							}).then(function(){
								window.location = "user-list";
							}); 
					  }
					  else if(msg == 'error'){
						swal("Oop! User Failed to Block!", {
						  icon: "warning",
						});
					  }
				  }
			  });
		  } else {
		   return false;
		  }
		});
		e.preventDefault();
	});
	// DELETE USER
	$(document).on("click", '.user_del',function(e){
		e.preventDefault();
		var del_code = $(this).attr("id");
		swal({
		  title: "Are you sure?",
		  text: "You want to delete this user!",
		  icon: "warning",
		  buttons: {
			cancel: "Cancel",
			catch: {
			  text: "Delete",
			  value: "catch",
			},
		  },
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			  $.ajax({
				  url:"ajax_files/user_deal.php",
				  method:"post",
				  data:{del_code:del_code},
				  success:function(msg){
					  if(msg == 'success'){
						  swal({
							  text:"Success! User has been Deleted!",
							  icon: "success"
							}).then(function(){
								window.location = "user-list";
							}); 
					  }
					  else if(msg == 'error'){
						swal("Oop! User Failed to Delete!", {
						  icon: "warning",
						});
					  }
				  }
			  });
		  } else {
		   return false;
		  }
		});
		e.preventDefault();
	});
	// Activate USER
	$(document).on("click", '.user_active',function(e){
		e.preventDefault();
		var active_code = $(this).attr("id");
		swal({
		  title: "Are you sure?",
		  text: "You want to active this user!",
		  icon: "warning",
		  buttons: {
			cancel: "Cancel",
			catch: {
			  text: "Active",
			  value: "catch",
			},
		  },
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			  $.ajax({
				  url:"ajax_files/user_deal.php",
				  method:"post",
				  data:{active_code:active_code},
				  success:function(msg){
					  if(msg == 'success'){
						  swal({
							  text:"Success! User has been Activated!",
							  icon: "success"
							}).then(function(){
								window.location = "user-list";
							}); 
					  }
					  else if(msg == 'error'){
						swal("Oop! User Failed to Activate!", {
						  icon: "warning",
						});
					  }
				  }
			  });
		  } else {
		   return false;
		  }
		});
		e.preventDefault();
	});
	$(document).ready(function () {
		// show detail
		$(document).on("mouseenter",'.ref_img_active',function(){
			var $div = $(this).next().next();
			$div.stop().fadeIn(500);
			
		});
		$(document).on("mouseleave",'.ref_img_active',function(){
			$(this).next().next().stop().fadeOut(100);
		});
		// get tree
		$(document).on("click",'.ref_img_active',function(event){
			event.preventDefault();
			$("#wait_tree").show();
			var user_id = $(this).attr("user-data");
			$.ajax({
				url:"ajax_files/get_tree.php",
				method:"post",
				data:{user_id:user_id},
				success:function(data){
					var v = '<div id="wait_tree"><div class="row h-100 justify-content-center align-items-center"><div class="col-12"><img src="images/spinner.gif" class="d-block mx-auto"></div></div></div>';
					$("#wait_tree").hide();
					$("#binary_tree_id").html(data);
					$("#binary_tree_id").append(v);
				}
			});
		});
	});
	// get tree
	$(document).on("click",'#downliner_btn',function(event){
		event.preventDefault();
		var $btn = $(this);
		var user_code = $("#downliner").val();
		var ref_user = $btn.attr("user-data");
		if(user_code == ''){
			$("#downliner").css("border","1px solid #F00");
		}
		else if(!/^\d+$/.test(user_code)){
			$("#downliner").css("border","1px solid #F00");
		}
		else{
			$("#downliner").css("border","none");
			$btn.html('<img src="images/spinner.gif" style="height:20px;width:20px;">');
			$.ajax({
				url:"ajax_files/get_tree.php",
				method:"post",
				data:{user_code:user_code,ref_user:ref_user},
				success:function(data){
					var v = '<div id="wait_tree"><div class="row h-100 justify-content-center align-items-center"><div class="col-12"><img src="images/spinner.gif" class="d-block mx-auto"></div></div></div>';
					$btn.html('Search');
					$("#binary_tree_id").html(data);
					$("#binary_tree_id").append(v);
				}
			});
		}
	});
</script>