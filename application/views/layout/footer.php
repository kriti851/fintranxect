<div class="footer section-space50">
    <!-- footer -->
    <div class="container top-full-width">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="widget-text mt40 text-center">
                    <!-- widget text -->
                    <p>
                     Our goal at FinTranxect is to provide access to loans, POS, UPI, Bill Payments, Insurance, Cash withdrawal & deposit & Loyalty based services. We cater to a wide range of businesses & are able to provide quality services to our consumers through our wide range of partnerships. 
                    </p>
                    <?php if(!empty($is_show_morquee)){ ?>
                    <marquee onclick="openForm()" style="font-weight: 800;color:white;" direction="left" behavior="scroll">Fintranxect Digital Solutions pvt Ltd is not a Bank or NBFC, the company sources it’s leads from it’s partners and does necessary documents collection from the prospect with prior consent.The documents are shared with NBFC and Bank with whom the company has signed DSA/Channel partner agreement.Fintranxect doesn't charge any fee to its customer nor is involved in loan decision making, Disbursement and emi collection.</marquee>
                    <style>
                        

                        .chat-popup {
                            display: none;
                            position: fixed;
                            bottom: 0;
                            right: 15px;
                            border: 3px solid #f1f1f1;
                            z-index: 9;
                            width:30%;
                            background:#c70c00;
                            border-radius: 10px;
                            box-shadow: 0px 1px 10px #d2d2d2;;
                            margin-bottom:15px;
                        }
                        .crossbtn{
                            background: #a1252b;
                            padding: 10px 12px 10px 10px;
                            margin-top: -8px;
                            border-radius: 4px;
                        }
                    </style>

                    <div class="chat-popup" id="myForm">
                        <form  class="form-container">
                            <a style="float:right;" class="crossbtn" type="button" onclick="closeForm()"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <p style="font-weight:800;" class="mt-2">
                                    Fintranxect Digital Solutions pvt Ltd is not a Bank or NBFC, the company sources it’s leads from it’s partners and does necessary documents collection from the prospect with prior consent.The documents are shared with NBFC and Bank with whom the company has signed DSA/Channel partner agreement.Fintranxect doesn't charge any fee to its customer nor is involved in loan decision making, Disbursement and emi collection.
                            </p>
                            
                        </form>
                    </div>

                    <script>
                        function openForm() {
                            document.getElementById("myForm").style.display = "block";
                        }

                        function closeForm() {
                            document.getElementById("myForm").style.display = "none";
                        }
                    </script>
                    <?php } ?>
                </div>
                <!-- /.widget text -->
            </div>
            
        </div>
    </div>
</div>