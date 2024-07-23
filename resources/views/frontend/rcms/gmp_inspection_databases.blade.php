@extends('frontend.rcms.Regulatorylayout.main_regulatory')

<script>
    // Function to update the options of the second dropdown based on the selection in the first dropdown
    function updateQueryOptions() {
        var scopeSelect = document.getElementById('scope');
        var querySelect = document.getElementById('query');
        var scopeValue = scopeSelect.value;

        // Clear existing options in the query dropdown
        querySelect.innerHTML = '';

        // Add options based on the selected scope
        if (scopeValue === 'Regulatory Inspection') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Audit Preparation', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Pending Response', '4'));
            querySelect.options.add(new Option('CAPA Execution in Progress', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));


        } 

    }
</script>
<style>
    #short_width{
        display: inline-block;
    width: 320px !important;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
    }
    .table-container {
  overflow: auto;
  /* max-height: 350px;
  max-height: 350px; */
}

.table-header11 {
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.table-body-new {
  margin-top: 30px;
}
.td_c{
    width: 100px !important;
}
.td_desc{
    width: 10px;
}
.main-head{
    padding: 10px;
    font-weight: bold;
    color: #1e1e59;
    font-size: 23px;
}
</style>
@section('rcms_container')
    <div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">


                <div>
                    <div class="inner-block scope-table" style="">
                    <div class="main-head">
                    GMP Inspection Databases
                    </div>
                    <div class="sub-heading p-2">
                    Here you will find the most important GMP Inspection databases. These databases help you search for compliance information for a specific manufacturing site. In addition to GMP compliance information, the EMA also provides information on Good Distribution Practices (GDP) compliance
                    </div>
                    <div class="sub-heading p-2">
                        <img src="https://gmp-compliance.org/files/eca/userImages/content/iStock-1283277714.jpg" alt="" class="" style="height: 400px; width:100%;">
                    </div>
                    <div class="main-head">
                    EudraGMDP Database
                    </div>
                    <div class="sub-heading p-2">
                
                    The European Medicine Agency (EMA) developed a database which contains both information on GMP and on GDP compliance. The competent authority in each European Member State is responsible for entering the data into the central database. On the one hand, the database provides information about the manufacturing (GMP) and distribution (GDP) authorisation. On the other hand, the database contains information about inspections which have been performed by the competent EU authorities. This enables EU member states to verify if other EU authorities have performed inspections at a specific site. For the time being, non-compliance information is only provided for GDP inspection outcomes.                    </div>
                    <div class="">
                    <a href="http://maintenance.ema.europa.eu/"  target="_blank"><button>Access EudraGMDP here</button> </a>
                </div>
                </div>
               

            </div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="record-modal">
        <div class="modal-contain">
            <div class="modal-dialog m-0">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body " id="auditTableinfo">
                        Please wait...
                    </div>

                </div>
            </div>
        </div>
    </div>

   
@endsection
