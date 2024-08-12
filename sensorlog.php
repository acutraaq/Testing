
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Sensor Log</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-success btn-sm py-1 rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="card-body">
    <table class="table table-hover table-striped table-bordered">
            <colgroup>
                <col width="5%">
                <col width="45%">
                <col width="25%">
                <col width="25%">
            </colgroup>
            <thead>
                <tr>
                    <th class="p-0 text-center">#</th>
                    <th class="p-0 text-center">Current Occupancy</th>
                    <th class="p-0 text-center">Sensor Door</th>
                    <th class="p-0 text-center">Reading Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                 $att_qry = $conn->query("SELECT * FROM sensorlog limit 0,20");
                 $i = 1;
                 while($row = $att_qry->fetchArray()):
                    $bg = "primary";
                    if(in_array($row['id'],array(2,4)))
                    $bg = "danger";
                ?>
                <tr>
                    <td class="align-middle py-0 px-1 text-center"><?php echo $i++; ?></td>
                    <td class="align-middle py-0 px-1">
                        <p class="m-0">
                            <?php echo $row['current_people'] ?>
                        </p>
                    </td>
                    <td class="align-middle py-0 px-1 text-center">
                        <span class="badge bg-<?php echo $bg ?>"><?php echo $row['sensor_door'] ?></span>
                    </td>
                    <td class="align-middle py-0 px-1 text-end"><?php echo date("M d, Y h:i A",strtotime($row['reading_time']))  ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('#print').click(function(){
            var _h = $("head").clone()
            var _table = $('#sensorlog').clone()
            var _el = $("<div>")
            _el.append(_h)
            _el.append("<h2 class='text-center'>Sensor Log</h2>")
            _el.append("<hr/>")
            _el.append(_table)

            var nw = window.open("","_blank","width=1200,height=900")
                     nw.document.write(_el.html())
                     nw.document.close()
                     setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                         nw.close()
                         }, 200);
                     }, 200);
        })
    })
</script>