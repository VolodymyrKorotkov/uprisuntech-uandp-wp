<?php
/**
 * Requests account page
 */
?>

<?php

if (!current_user_can('read_requests') ) return;

if (isset($_GET['id'])): ?>
<?php
require get_template_directory() . '/lifterlms/myaccount/requests-approve.php';
?>
<?php else: ?>

<?php
$page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
$current_lang = apply_filters( 'wpml_current_language', 'uk' );

llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>
    <?php
    if(get_current_user_role()=="operator") {
        $statuses = [
            'Await processing', 'Approved', 'Rejected',
        ];
    }else{
        $statuses = [
            'Active', 'Inactive',
//            'Await', 'In progress','Rejected','Submitted','Return to application'
        ];
        $engineerStat = [
            'Active' => ['await', 'in progress', 'pending'],
            'Inactive' => ['submitted', 'return to application', 'reject', 'rejected', 'returned', 'processed'],
        ];
    }

    $requestsByStatus = [];

    //проверка срока действия запроса 7 дней
    global $wpdb;
    $current_time = date("Y-m-d H:i:s");
    $cycle = 0;
    foreach ($statuses as $status) {
    $cycle++;
        if(get_current_user_role()=="operator"){
            $requestsArray = get_municipality_requests([
                'where' => " WHERE `status`='{$status}'",
                'parseRequests' => true,//date format
            ]);
            if (!empty($requestsArray['requests'])) {
                $requests = $requestsArray['requests'];

                foreach ($requests as $k => $request) {
                    $id = $request->id;
                    $due_to = $request->due_to;

                    if ($status == 'Await processing' && $request->status == 'Await processing') {
                        if ($due_to && !preg_match('/0000/', $due_to)) {
                            $due_to = date("Y-m-d H:i:s", strtotime($due_to));

                            if ($current_time > $due_to) {
                                $table_name = $wpdb->prefix . 'municipality_requests';
                                $wpdb->update( $table_name,
                                    [
                                        'status' => 'Rejected',
                                        'assigned' => __('Automatically', 'ndp'),
                                        'last_change' => $current_time,
                                    ],
                                    [ 'id' => $id ]
                                );
                                unset($requests[$k]);
                            }
                        }
                    }
                }
                $requestsByStatus[$status]['requests'] = $requests;
            }
        } else if(get_current_user_role()=="engineer" && $cycle == 1){
            $sort_by = 'updated_at';
            $engineerStatusArray = isset($engineerStat[$sort_by])? $engineerStat[$sort_by] : [];
            $engineerStatus = [];
            foreach ($engineerStatusArray as $item) {
                $engineerStatus[] = '`status`='."'".$item."'";
            }

            $requests = get_applications_with_engineer(
                [
                    'where' => implode(' OR ', $engineerStatus),
                ]
            );

            usort($requests, function($a, $b) {
                return strtotime($b['updated_at']) - strtotime($a['updated_at']);
            });
            
            foreach ($requests as $k => $request) {
                $id = $request['id'];
                $date_added = $request['date_added'];
                $requests[$k]['date_added'] = date('d.m.y', strtotime($date_added));
                $date = $date_added;
                $date = strtotime($date);
                $date = strtotime("+7 days", $date);
                $due_to = date('Y-m-d H:i:s', $date);
                $requests[$k]['due_to'] = date('d.m.y', $date);

//                if ($status == 'Active' && $request['status'] == 'pending') {
//                    if ($date_added && $due_to && !preg_match('/0000/', $date_added)) {
//
//                        if ($current_time > $due_to) {
//                            $table_name = $wpdb->prefix . 'applications';
//                            $wpdb->update( $table_name,
//                                [
//                                    'status' => 'reject',
//                                    'updated_at' => $current_time,
//                                    'status_updated_at' => $current_time,
//                                ],
//                                [ 'id' => $id ]
//                            );
//                            unset($requests[$k]);
//                        }
//                    }
//                }
            }
            $requestsByStatus[$status]['requests'] = $requests;
        }
    }
    ?>





  <div class="account__content col-8" style="width: auto">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <div class="d-lg-flex justify-content-between align-items-center mb-20">
      <h1 class="h1"><?php _e('Requests', 'ndp'); ?></h1>


    <!-- filter -->
    <div class="blockFilterSolar">
    <?php if(get_current_user_role()=="engineer"){?>
        <div class="filtersSolar button-filterIng">
                <div class="selectSolarFilter"></div>
                <div class="placeholderfilter"><?php _e('Category', 'ndp'); ?></div>
                <div class="listSolar">
                    <div class="acc-filter-solar-btn" data-solar="All"><?php _e('All category', 'ndp'); ?></div>
                    <div class="acc-filter-solar-btn" data-solar="Solar energy"><?php _e('Solar energy', 'ndp');?></div>
                    <div class="acc-filter-solar-btn" data-solar="Other"><?php _e('Other', 'ndp');?></div>
                </div>       
        </div>
    <?php } ?>

        <div class="filtersActive button-filterIng">
                <div class="selectActiveFilter"></div>
                <div class="placeholderfilter"><?php _e('Status', 'ndp'); ?></div>
                <div class="listActive">
                <div class="acc-filter-aсtive-btn" data-status="All"><?php _e('All statuses', 'ndp'); ?></div>
                <?php
                $i=0;
                
                foreach ($statuses as $status){ ?>
                    <?php if($i==0){
                    
                    $tabStatus = $status;
                        if ($current_lang == 'uk' && $status == 'Rejected') {
                        $tabStatus = 'Deflected';
                        } ?>
                    <div class="acc-filter-aсtive-btn" data-status="<?php echo $status; ?>"><?php _e($tabStatus, 'ndp'); ?></div>
                    <?php }else{ ?>
                    <div class="acc-filter-aсtive-btn" data-status="<?php echo $status; ?>"><?php _e($status, 'ndp'); ?></div>
                    <?php } ?>
                <?php } ?>
                </div>
        </div>

        
        <div class="filtersAddTime button-filterIng">
                <div class="selectAddTimeFilter">---</div>
                <div class="placeholderfilter"><?php _e('Sort by Time', 'ndp'); ?></div>
                <div class="listAddTime">
                    <div class="acc-filter-addtime-btn" data-addtime="start"><?php _e('New first', 'ndp');?></div>
                    <div class="acc-filter-addtime-btn" data-addtime="end"><?php _e('Old first', 'ndp');?></div>
                </div>       
        </div>


    </div>
    <!-- endfilter -->



    </div>
    <div class="acc-tabs__content">
    <div class="acc-box acc-box--indent">
        <div class="acc-table-scroll-y">
            <div class="acc-table-scroll-x">
                <table class="acc-table">
                    <tr>
                        <th><?php _e('Request', 'ndp'); ?></th>
                        <th><?php _e('Status', 'ndp'); ?></th>
                        <th><?php _e('Received', 'ndp'); ?></th>
                        <!-- <th><?php  //_e('Due to', 'ndp'); ?></th> -->
                        <th><?php _e('Type', 'ndp'); ?></th>
                        <th><?php _e('Assigned', 'ndp'); ?></th>
                        <th><?php _e('Детальніше', 'ndp'); ?></th>
                    </tr>
                    <?php foreach ($statuses as $status): ?>
                        <?php
                        $statusColorClasses = [
                            'Await processing' => 'c-label__item--gold',
                            'Approved' => 'c-label__item--green',
                            'Rejected' => 'c-label__item--red',
                        ];
                        $dataColorClass = '';
                        if (!empty($statusColorClasses[$status])) {
                            $dataColorClass = $statusColorClasses[$status];
                        }
                        ?>
                        <div class="acc-tabs__content-item" data-status="<?php echo $status; ?>" data-color-class="<?php echo $dataColorClass; ?>">
                            <?php if (get_current_user_role() == "operator"): ?>
                                <?php
                                $requests = [];
                                if (!empty($requestsByStatus[$status]) && !empty($requestsByStatus[$status]['requests'])) {
                                    $requests = $requestsByStatus[$status]['requests'];
                                }
                                ?>
                                <?php foreach ($requests as $request): ?>
                                    <?php
                                    get_template_part('templates/tr-operator-request', '', [
                                        'request' => $request,
                                    ]);
                                    ?>
                                <?php endforeach; ?>
                            <?php elseif (get_current_user_role() == "engineer"): ?>
                                <?php
                                $requests = [];
                                if (!empty($requestsByStatus[$status]) && !empty($requestsByStatus[$status]['requests'])) {
                                    $requests = $requestsByStatus[$status]['requests'];
                                }
                                ?>
                                <?php foreach ($requests as $request): ?>
                                    <?php if ($request['status'] !== 'draft'): ?>
                                        <?php $solar = json_decode($request['apply_info'], true); ?>
                                        <?php
                                                    $colorClass = 'c-label__item--gold';
                                                    if ($request['status'] == 'submitted' || $request['status'] == 'processed') {
                                                        $colorClass = 'c-label__item--blue';
                                                    } elseif ($request['status'] == 'reject' || $request['status'] == 'rejected') {
                                                        $colorClass = 'c-label__item--red';
                                                    } elseif ($request['status'] == 'in progress') {
                                                        $colorClass = 'c-label__item--gold';
                                                    } elseif ($request['status'] == 'return to application' || $request['status'] == 'returned') {
                                                        $colorClass = 'c-label__item--grey';
                                                    }
                                                    ?>
                                                    
                                        <tr class="tr-request-data <?php echo get_current_user_role();?>" data-status="<?php echo $colorClass == 'c-label__item--gold' ? 'Active' : 'Inactive'; ?>" data-solar="<?php echo $solar['project_information']['project_type']; ?>">
                                            <td class="blue-color semi">№<?php echo $request['id']; ?></td>
                                            <td>
                                                <div class="c-label">
                                                    

                                                    <div class="c-label__item <?php echo $colorClass; ?>" data-status="<?php _e($status, 'ndp'); ?>"><?php echo mb_ucfirst(__($request['status'], 'ndp')); ?></div>
                                                </div>
                                            </td>
                                            <td class="date_added-time"><?php echo $request['date_added']; ?></td>
                                            <!-- <td> <?php //echo $request['due_to']; ?></td> -->
                                            <td><?php _e('Commercial', 'ndp'); ?></td>
                                            <td><?php _e('Automaticaly', 'ndp'); ?></td>

                                            <td>
                                                <div class="acc-table__nav">
                                                    <?php
                                                    $current_language = apply_filters('wpml_current_language', NULL);
                                                    if ($current_language == "en") {
                                                        $link = "/en/application-engineer/?id=" . $request['id'];
                                                    } else {
                                                        $link = "/application-engineer/?id=" . $request['id'];
                                                    }

                                                    ?>
                                                    <a href="<?php echo $link; ?>"
                                                       class="acc-table__nav-btn">
                                                        <svg width="8" height="12" viewBox="0 0 8 12"
                                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                    d="M5.05001 6L0.325012 1.275L1.60001 0L7.60001 6L1.60001 12L0.325012 10.725L5.05001 6Z"
                                                                    fill="black"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
        <div id="pagination"></div>
</div>

  </div>
<?php endif; ?>




<!-- filter active -->
<script>
   
   var filterAct, filterSol, filterAddTime;


    //filter AddTime  
    $('.acc-filter-addtime-btn').click(function() {
        filterAddTime = $(this).attr('data-addtime');
        filterAddTimeText = $(this).text();
        $('.selectAddTimeFilter').text(filterAddTimeText);
        filterAddTime = filterAddTime.trim().toLowerCase();
        sortAddTime();
    });                                     
    
    function sortAddTime(){
        // Получаем все строки таблицы и сортируем их по значению в столбце с классом "date_added-time"
        var rows = $('.acc-table tbody > tr').get();
        rows.sort(function(a, b) {
            var dateStrA = $(a).find('td.date_added-time').text();
            var dateStrB = $(b).find('td.date_added-time').text();
            // Преобразуем строку в дату, используя формат "день.месяц.год"
            var dateA = getDateFromDateString(dateStrA);
            var dateB = getDateFromDateString(dateStrB);
            if(filterAddTime == 'start'){
                return dateB - dateA;
            }
            return dateA - dateB;
        });
        
        


        $.each(rows, function(index, row) {
            $('.acc-table tbody').append(row);

            $('.acc-filter-aсtive-btn.selected').click();
            $('.filtersActive').removeClass('show');
            $('.acc-filter-solar-btn.selected').click();
            $('.filtersSolar').removeClass('show');
    });


    function getDateFromDateString(dateStr) {
        var parts = dateStr.split('.');
    return new Date(parts[2], parts[1] - 1, parts[0]); // Год, месяц (нумерация с 0), день
}
}



//filter data-atributes
    $('.acc-filter-aсtive-btn').click(function() {
        filterAct = $(this).attr('data-status');
        filterActText = $(this).text();
        $('.selectActiveFilter').text(filterActText);
        filterAct = filterAct.trim().toLowerCase();
        filterData();
    });

    $('.acc-filter-solar-btn').click(function() {
        filterSol = $(this).attr('data-solar');
        filterSolText = $(this).text();
        $('.selectSolarFilter').text(filterSolText);
        filterSol = filterSol.trim().toLowerCase();

        if(filterSol === 'other'){
            $('.acc-filter-aсtive-btn:last').click();
            $('.filtersActive').removeClass('show').addClass('disable');
        } else {
            $('.filtersActive').removeClass('disable');
        }
        filterData();
    });

    function filterData() {
        $('.tr-request-data').each(function() {
            var statusSol = $(this).attr('data-solar') ? $(this).attr('data-solar').trim().toLowerCase() : undefined;
            var statusAct = $(this).attr('data-status') ? $(this).attr('data-status').trim().toLowerCase() : undefined;

            // проверка для инженера
            if(filterSol !== undefined){
                if(filterAct === 'all' && filterSol === 'all') {
                $(this).addClass('enableRecord');
                }else if (filterAct === 'all' && statusSol === filterSol){
                    $(this).addClass('enableRecord');
                }else if (filterSol === 'all' && statusAct === filterAct){
                    $(this).addClass('enableRecord');
                }else if(statusAct === filterAct && statusSol === filterSol) {
                    $(this).addClass('enableRecord');
                } else {
                    $(this).removeClass('enableRecord');
                }
            }
            else if (filterSol === undefined){ // проверка для оператора
            // проверка для оператора
           
                if(filterAct === 'all' ) {
                    $(this).addClass('enableRecord');
                }else if (statusAct === filterAct){
                    $(this).addClass('enableRecord');
                }else {
                    $(this).removeClass('enableRecord');
                }
            }
        });
        paginationReCreate();
    }
</script>

<script>
// фильтра


    $('.filtersAddTime').click(function(e){
        e.stopPropagation(); // Предотвращает всплытие события, чтобы не срабатывал обработчик ниже
        $(this).toggleClass('show');
    });
    
    $(document).click(function(e) {
        if (!$(e.target).closest('.filtersAddTime').length) {
            $('.filtersAddTime').removeClass('show');
        }
    });

    $('.filtersSolar').click(function(e){
        e.stopPropagation(); // Предотвращает всплытие события, чтобы не срабатывал обработчик ниже
        $(this).toggleClass('show');
    });
    
    $(document).click(function(e) {
        if (!$(e.target).closest('.filtersSolar').length) {
            $('.filtersSolar').removeClass('show');
        }
    });


    $('.filtersActive').click(function(e){
        if ($(this).hasClass('disable')) {       
            return false;
        }
        e.stopPropagation(); // Предотвращает всплытие события, чтобы не срабатывал обработчик ниже
        $(this).toggleClass('show');
    });
    
    $(document).click(function(e) {
        if (!$(e.target).closest('.filtersActive').length) {
            $('.filtersActive').removeClass('show');
        }
    });

//  список

    $('.acc-filter-addtime-btn').click(function(){
        $('.acc-filter-addtime-btn').removeClass('selected'); 
        $(this).addClass('selected');
    });

    $('.acc-filter-aсtive-btn').click(function(){
        $('.acc-filter-aсtive-btn').removeClass('selected'); 
        $(this).addClass('selected');
    });

    $('.acc-filter-solar-btn').click(function(){
        $('.acc-filter-solar-btn').removeClass('selected'); 
        $(this).addClass('selected');
    });

</script>


<!-- pagination -->
<script>
function paginationReCreate() {
    var itemsPerPage = 10; // Количество элементов на странице
    var $items = $('.enableRecord'); // Все элементы с классом "enableRecord"
    var itemCount = $items.length; // Общее количество элементов
    var pageCount = Math.ceil(itemCount / itemsPerPage); // Общее количество страниц

    // Функция для отображения элементов на странице
    function showPage(page) {
        var start = (page - 1) * itemsPerPage;
        var end = start + itemsPerPage;

        // Скрываем все элементы и затем показываем только необходимые для текущей страницы
        $items.removeClass('paginationShow').slice(start, end).addClass('paginationShow');
    }

    // Функция для создания ссылок пагинации
    function createPaginationLinks() {
        $('#pagination').empty();
        if(pageCount > 1){
            for (var i = 1; i <= pageCount; i++) {
                if(i === 1){
                    $('#pagination').append('<a href="#" class="page-link selected" data-page="' + i + '">' + i + '</a> ');
                }else{
                    $('#pagination').append('<a href="#" class="page-link" data-page="' + i + '">' + i + '</a> ');
                }
            }
        }
        $('.page-link').on('click', function(){
            $(this).addClass('selected');
            $('.page-link').not(this).removeClass('selected');
        });
    }
    // add select .page-link

    // Инициализация
    createPaginationLinks();
    showPage(1); // Показываем первую страницу по умолчанию

    // Обработчик клика на ссылку пагинации
    $('#pagination').on('click', '.page-link', function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        showPage(page);
    });
};




$('.acc-filter-aсtive-btn:first').click();
$('.filtersActive').removeClass('show');
$('.acc-filter-solar-btn:first').click();
$('.filtersSolar').removeClass('show');

</script>





<style>
    .listSolar div, .listActive div,.listAddTime div{
        width: 150px;
        padding: 10px;
        box-sizing: border-box;
        background:white;
    }
    .blockFilterSolar{
        display:flex;
    }
    .listActive,.listSolar,.listAddTime{
        display: none;
    }
    .filtersSolar.show .listSolar,
    .filtersActive.show .listActive,
    .filtersAddTime.show .listAddTime{
        display:block;
        position:absolute;
        z-index: 100;

        /* background: white; */
        width: 150px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    .filtersActive.disable {
        background: gainsboro;
    }

    .acc-filter-solar-btn.selected{
        background: gainsboro;
    }
    .acc-filter-aсtive-btn.selected{
        background: gainsboro;
    }
    .acc-filter-addtime-btn.selected{
        background: gainsboro;
    }


    .placeholderfilter{
        position: absolute;
        left: 12px;
        top: -8px;
        font-size: 12px;
        color: #79767d;
        background: #F5F5F6;
        padding: 0 4px;
    }
    /* pagination */
    .tr-request-data{
        display: none;
    }
    .enableRecord{
        display:table-row;
    }
    .enableRecord:not(.paginationShow) {
        display: none;
    }

    /* pagination button */
    .page-link{
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .page-link.selected{
        background:#2a59bd;
        color:white;
    }

    /* dropdawn */


    .button-filterIng{
        position:relative;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 150px;
        /* background: white; */
        margin: 10px;
        cursor:pointer;
    }

    .button-filterIng:after{
        content: "";
        position: absolute;
        top: 0;
        right: 11px;
        bottom: 0;
        width: 11px;
        height: 5px;
        margin: auto;
        background: url(https://explainpitch.com/uploads/2022/12/select-arrow.svg) center/contain no-repeat;
        filter: brightness(0);
    }
    .selectSolarFilter,.selectActiveFilter, .selectAddTimeFilter{
        width: 100%;
        padding: 15px 20px;
        margin: auto;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }  
    @media (max-width:992px){
        .blockFilterSolar{
            flex-direction: column;
        }
        .acc-table-scroll-x{
            overflow: scroll;
        }
        #pagination{
            display: grid;
            grid-template-columns: repeat(5, 45px);
            gap: 10px;
            text-align:center;
        }
        .account__content{
            width:100%!important;
        }
    }
</style>

<style>
.c-label__item--blue {
    background: #DAE2FF;
    color: #2A59BD;
}

.c-label__item--grey {
    background: #E9E7EC;
     color: #71768B;
}
</style>