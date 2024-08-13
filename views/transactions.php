<?php include("includes/dashboard_header.php");?>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Transactions</h2>
            </div>
          </header>
		  <ul class="nav nav-pills nav-justified mt-3 mx-4" style="background-color:#000;border-radius:1.25rem;">
				<li class="nav-item"><a data-toggle="tab"  class="nav-link active" href="#ranks">Personal Transactions</a></li>
				<li class="nav-item"><a data-toggle="tab" class="nav-link" href="#refferals">All Transactions</a></li>
			</ul>
		<div class="tab-content">
			  <section class="tables pt-3 tab-pane fade show active" id="ranks">   
				<div class="container-fluid">
				  <div class="row">
					<div class="col-lg-12">
					  <div class="card">
						<div class="card-header d-flex align-items-center">
						  <h3 class="h4">Personal Transactions</h3>
						</div>
						<div class="card-body">
						  <div class="table-responsive">
							<table class="table table-md" id="my_table">
                          <thead>
                            <tr>
                              <th>TXN ID</th>
                              <th>AMOUNT</th>
                              <th>TYPE</th>
							  <th>DATE</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
								$txnQ = $conex->query("SELECT * FROM user_trxn WHERE USER_CODE = '$user_code' ORDER BY DATE_TIME DESC");
								while($txn = $txnQ->fetch_assoc()){
							?>
								<tr>
									<td><?=$txn['TXN_ID'];?></td>
									<td><?=$txn['AMOUNT'];?>$</td>
									<td><?=get_txn_type($txn['TYPE']);?></td>
									<td><?=date('Y-m-d', strtotime($txn['DATE_TIME']));?></td>
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
			 <section class="tables tab-pane fade pt-3" id="refferals">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">All Transactions</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-md" id="my_table2">
                          <thead>
                            <tr>
                              <th>TXN ID</th>
                              <th>AMOUNT</th>
                              <th>TYPE</th>
							  <th>DATE</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
								$txnQ = $conex->query("SELECT * FROM user_trxn  WHERE DATE_TIME > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY DATE_TIME DESC");
								while($txn = $txnQ->fetch_assoc()){
							?>
								<tr>
									<td><?=$txn['TXN_ID'];?></td>
									<td><?=$txn['AMOUNT'];?>$</td>
									<td><?=get_txn_type($txn['TYPE']);?></td>
									<td><?=date('Y-m-d', strtotime($txn['DATE_TIME']));?></td>
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
<?php include("includes/dashboard_footer.php");?>