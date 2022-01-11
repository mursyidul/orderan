<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Schedule</h2>
        <ol class="breadcrumb">
            <li><a  href="<?php echo base_url('Dashboard'); ?>">Dashboard</a></li>
            <li class="active"><strong><a>Schedule</a></strong></li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div id="calendar"></div>  
                                </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--  -->

<script>

    $(document).ready(function() {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

        /* initialize the external events
         -----------------------------------------------------------------*/


        $('#external-events div.external-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            navLinks: true,
            selectable: true,
            selectMirror: true,
            droppable: true, // this allows things to be dropped onto the calendar
            
             dayClick: function(date, jsEvent, view) { 
                // var dateClick = date._d.toLocaleDateString();
                var bulan = date._d.getMonth() + 1;
                var tanggal = date._d.getDate();
                if (bulan >= 10) {
                    var bulan_sekarang = date._d.getMonth() + 1;
                } else {
                    var bulan_sekarang = "0"+(date._d.getMonth() + 1);
                }

                if (tanggal >= 10) {
                    var tanggal_sekarang = date._d.getDate();
                } else {
                    var tanggal_sekarang = "0"+ date._d.getDate();
                }
                var newDate = date._d.getFullYear() + "-" + bulan_sekarang + "-" + tanggal_sekarang;
                <?php if ($this->session->userdata("role") == "ADMIN") { ?>
                 window.location="<?php echo site_url('schedule/tambah?date='); ?>"+ newDate;
                <?php } ?>
              },

            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            // dayMaxEvents: true,
            events: [

                    <?php
                        if ($this->session->userdata("role") == "ADMIN") {
                            foreach ($calendar as $list){
                                // echo console.log($list['tanggal']);
                                echo "{";
                                echo "title:'".$list['jumlah']." Orang ".$list['nm_shift']."',";
                                // echo "title:'".$list['jumlah']." Orang',";
                                echo "start:'".date('Y-m-d', strtotime($list["tanggal"]))."'";
                                echo "},"; 
                            }
                        } else {
                           foreach ($calendar_user as $list){
                                // echo console.log($list['tanggal']);
                                echo "{";
                                echo "title:'".$list['nm_shift']."',";
                                // echo "title:'".$list['jumlah']." Orang',";
                                echo "start:'".date('Y-m-d', strtotime($list["tanggal"]))."'";
                                echo "},"; 
                            } 
                        }
                    ?>


                // {
                //     title: 'All Day Event',
                //     start: '2020-08-01'
                // },
                // {
                //     title: 'Long Event',
                //     start: new Date(y, m, d-5),
                //     end: new Date(y, m, d-2)
                // },
                // {
                //     id: 999,
                //     title: 'Repeating Event',
                //     start: new Date(y, m, d-3, 16, 0),
                //     allDay: false
                // },
                // {
                //     id: 999,
                //     title: 'Repeating Event',
                //     start: new Date(y, m, d+4, 16, 0),
                //     allDay: false
                // },
                // {
                //     title: 'Meeting',
                //     start: new Date(y, m, d, 10, 30),
                //     allDay: false
                // },
                // {
                //     title: 'Lunch',
                //     start: new Date(y, m, d, 12, 0),
                //     end: new Date(y, m, d, 14, 0),
                //     allDay: false
                // },
                // {
                //     title: 'Birthday Party',
                //     start: new Date(y, m, d+1, 19, 0),
                //     end: new Date(y, m, d+1, 22, 30),
                //     allDay: false
                // },
                // {
                //     title: 'Click for Google',
                //     start: new Date(y, m, 28),
                //     end: new Date(y, m, 29),
                //     url: 'http://google.com/'
                // }
            ]
        });

    });

</script> 
