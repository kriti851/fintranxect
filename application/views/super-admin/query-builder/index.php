<style>
/* .form-control{
    height:32px !important;
} */

</style>

<div class="section-space40 bg-white">
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <h2>Query Builder</h2>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li class="active"><a href="#!">Query Builder</a></li>
                    </ol>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="breadcrumb-form">					
                </div>
            </div>
            
            <?php $this->load->view('super-admin/layout/sidebar'); ?>
           
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-12 mb30">
                <div class="dashboard-box-right">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="text-left">
                                Query Builder
                            </h3>
                            <form class="" method="get">
                                <div class="teble-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Column</th>
                                                <th scope="col">Operator</th>
                                                <th scope="col">Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th >Partner List</th>
                                                <td>
                                                    <select class="form-control" >
                                                        <option value="=">=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="dsa_id">
                                                        <option value=""></option>
                                                        <?php foreach($dsa_list as $dsa){ ?>
                                                        <option value="<?php echo $dsa->user_id; ?>"><?php echo $dsa->company_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Lender List</th>
                                                <td>
                                                    <select class="form-control" >
                                                        <option value="=">=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="lender_id">
                                                        <option value=""></option>
                                                        <?php foreach($lender_list as $lender){ ?>
                                                        <option value="<?php echo $lender->user_id; ?>"><?php echo $lender->company_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Case Id</th>
                                                <td>
                                                    <select class="form-control" name="users_file_id_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_file_id" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <th >Loan Type</th>
                                                <td>
                                                    <select class="form-control" name="users_loan_type_operator" >
                                                        <option value="=">=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="users_loan_type" >
                                                        <option value=""></option>
                                                        <option value="Salaried">Salaried</option>
                                                        <option value="Business">Business</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Full Name</th>
                                                <td>
                                                    <select class="form-control" name="users_full_name_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_full_name" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Company Name</th>
                                                <td>
                                                    <select class="form-control" name="users_company_name_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_company_name" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>
                                                    <select class="form-control" name="users_email_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_email" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Mobile Number</th>
                                                <td>
                                                    <select class="form-control" name="users_mobile_number_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_mobile_number" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Age</th>
                                                <td>
                                                    <select class="form-control" name="users_age_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_age" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Create Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_created_at',this.value)" name="users_created_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_created_at" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Received Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_received_time',this.value)" name="users_received_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_received_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Short Close Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_short_close_time',this.value)" name="users_short_close_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_short_close_time" class="form-control">
                                                </td>
                                            </tr>

                                            
                                            <tr>
                                                <th >Comment Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_comment_time',this.value)" name="users_comment_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_comment_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Remark Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_remark_time',this.value)" name="users_remark_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_remark_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Assigned Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('users_assigned_time',this.value)" name="user_assigned_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="users_assigned_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Logged Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('user_logged_time',this.value)" name="user_logged_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="user_logged_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Pending Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('user_pending_time',this.value)" name="user_pending_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="user_pending_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Approved Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('user_approved_time',this.value)" name="user_approved_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="user_approved_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Reject Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('user_reject_time',this.value)" name="user_reject_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="user_reject_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Disbursed Time</th>
                                                <td>
                                                    <select class="form-control" onchange="DatepickerOperator('user_disbursed_time',this.value)" name="user_disbursed_operator" >
                                                        <option value="=">=</option>
                                                        <option value=">=">>=</option>
                                                        <option value="<="><=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                        <option value="BETWEEN">BETWEEN</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="user_disbursed_time" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >City</th>
                                                <td>
                                                    <select class="form-control" name="city_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="city" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Pincode</th>
                                                <td>
                                                    <select class="form-control" name="pincode_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="pincode" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >State</th>
                                                <td>
                                                    <select class="form-control" name="state_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="state" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Firm Type</th>
                                                <td>
                                                    <select class="form-control" name="type_of_firm_operator" >
                                                        <option value="=">=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="type_of_firm" >
                                                        <option value=""></option>
                                                        <option value="Individual">Individual</option>
                                                        <option value="Proprietorship">Proprietorship</option>
                                                        <option value="Partnership">Partnership</option>
                                                        <option value="PVT .ltd">PVT .ltd</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Father Name</th>
                                                <td>
                                                    <select class="form-control" name="father_name_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="father_name" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Qualification</th>
                                                <td>
                                                    <select class="form-control" name="qualification_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="qualification" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Marital Status</th>
                                                <td>
                                                    <select class="form-control" name="marital_status_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="marital_status" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Employer Name</th>
                                                <td>
                                                    <select class="form-control" name="employer_name_operator" >
                                                        <option value="=">=</option>
                                                        <option value="LIKE">LIKE</option>
                                                        <option value="LIKE %...%">LIKE %...%</option>
                                                        <option value="NOT LIKE">NOT LIKE</option>
                                                        <option value="IN(...)">IN(...)</option>
                                                        <option value="NOT IN(...)">NOT IN(...)</option>
                                                        <option value="= ''">= ''</option>
                                                        <option value="!= ''">!= ''</option>
                                                        <option value="IS NULL">IS NULL</option>
                                                        <option value="IS NOT NULL">IS NOT NULL</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="employer_name" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Status</th>
                                                <td>
                                                    <select class="form-control" name="status_operator" >
                                                        <option value="=">=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="status" >
                                                        <option value=""></option>
                                                        <option value="INCOMPLETE">INCOMPLETE</option>
                                                        <option value="RECEIVED">RECEIVED</option>
                                                        <option value="SHORTCLOSE">SHORTCLOSE</option>
                                                        <option value="ASSIGNED">ASSIGNED</option>
                                                        <option value="LOGGED">LOGGED</option>
                                                        <option value="PENDING">LOGGED</option>
                                                        <option value="APPROVED">APPROVED</option>
                                                        <option value="REJECTED">REJECTED</option>
                                                        <option value="DISBURSED">DISBURSED</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th >Order BY</th>
                                                <td>
                                                    <select class="form-control" name="orderby_operator" >
                                                        <option value=""></option>
                                                        <option value="ASC">ASC</option>
                                                        <option value="DESC">DESC</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="order_by" >
                                                        <option value=""></option>
                                                        <option value="users.created_at">Create</option>
                                                        <option value="users.updated_at">Update</option>
                                                        <option value="users.received_time">Received</option>
                                                        <option value="users.short_close_time">Short Close</option>
                                                        <option value="user_lender_assign.assigned_time">Assigned</option>
                                                        <option value="user_lender_assign.logged_time">Logged</option>
                                                        <option value="user_lender_assign.pending_time">Pending</option>
                                                        <option value="user_lender_assign.approved_time">Approve</option>
                                                        <option value="user_lender_assign.reject_time">Reject</option>
                                                        <option value="user_lender_assign.disbursed_time">Disbursed</option>
                                                        <option value="users.case_id">Case Id</option>
                                                        <option value="users.full_name">Full Name</option>
                                                        <option value="users.company_name">Company Name</option>
                                                        <option value="users.email">Email</option>
                                                        <option value="users.age">Age</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Per Page </th>
                                                <td><select class="form-control" name="per_page" >
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="500">500</option>
                                                </select></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <footer>

                                        <button class="btn btn-primary">Submit</button>
                                    </footer>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("builder-li").classList.add("active");
</script>