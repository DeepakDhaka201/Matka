<!DOCTYPE html>
<html>
  <head>
    <meta charSet="utf-8" />
    <title>Records History Old Historical Data</title>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="next-head-count" content="7" />
    <link rel="preload" href="_next/static/css/3bb03e7f5a6da8ea.css" as="style" />
    <link rel="stylesheet" href="_next/static/css/3bb03e7f5a6da8ea.css" data-n-g="" />
    <noscript data-n-css=""></noscript>
    <script defer="" nomodule="" src="_next/static/chunks/polyfills-5cd94c89d3acac5f.js"></script>
    <script src="_next/static/chunks/webpack-9b312e20a4e32339.js" defer=""></script>
    <script src="_next/static/chunks/framework-5f4595e5518b5600.js" defer=""></script>
    <script src="_next/static/chunks/main-f65e66e62fc5ca80.js" defer=""></script>
    <script src="_next/static/chunks/pages/_app-f19c4352b6a07405.js" defer=""></script>
    <script src="_next/static/chunks/pages/mrecords/%5bgamename%5d-27bcef609df293a4.js" defer=""></script>
    <script src="_next/static/KgXTUAKfe_JqCprELWkER/_buildManifest.js" defer=""></script>
    <script src="_next/static/KgXTUAKfe_JqCprELWkER/_ssgManifest.js" defer=""></script>
    <script src="_next/static/KgXTUAKfe_JqCprELWkER/_middlewareManifest.js" defer=""></script>
  </head>
  <body>
    <div id="__next" data-reactroot="">
      <div class="w-full" style="overflow-y:hidden">
        <div class="flex flex-col items-center min-h-screen mt-10">
          <div class="divTable">
            <div class="gameNameChart"> {{ market.name }} </div>

            <div class="divResultsTable">
              <table class="clsResultsTable">
                <thead>
                  <tr>
                    <td class="thChartResult">Date</td>
                    <td class="thChartResult">Mon</td>
                    <td class="thChartResult">Tue</td>
                    <td class="thChartResult">Wed</td>
                    <td class="thChartResult">Thu</td>
                    <td class="thChartResult">Fri</td>
                    <td class="thChartResult">Sat</td>
                    <td class="thChartResult">Sun</td>
                  </tr>
                </thead>

                <tbody>
                        <?php
                        $results = query("select * from manual_market_results where market='$market' ORDER BY STR_TO_DATE(date, '%d/%m/%Y')");
                        $i = 0;
                        while($rrs = fetch($results)){
                            $data[$rrs['date']]['open_panna'] = $rrs['open_panna'];
                            $data[$rrs['date']]['open'] = $rrs['open'];
                            $data[$rrs['date']]['close'] = $rrs['close'];
                            $data[$rrs['date']]['close_panna'] = $rrs['close_panna'];
                            
                            if($i == 0) {
                                $first_date = $rrs['date'];
                            }
                            $i++;
                        }
                        
                        if($i == 0){
                            echo "<h2 style='padding:50px'>No Chart Data Available</h2>";
                            return;
                        }
                        
                        $explode = explode("/", $first_date);
                        $start_time = strtotime($explode[2].'-'.$explode[1].'-'.$explode[0]);
                        $end_time = time();
                        
                        
                        for($d = $start_time; $d < $end_time; $d = $d+86400) {
                            if(date('l', $d) == "Monday" || $first_date == date('d/m/Y', $d)){ ?>
                                
                                <tr>
                                    <td class="thChartResult">
                                      <div class="tdDate">
                                        <div class="dateDivLeft">
                                          <!-- --><?php echo date('Y', $d); ?>
                                          <!-- -->
                                        </div>
                                        <div class="dateDivRight flex flex-col align-middle">
                                          <div class="dateDivTop">
                                            <!-- --><?php echo date('d-M', $d); ?>
                                            <!-- -->
                                            <br /> to
                                          </div>
                                          <div class="dateDivBottom">
                                              <?php if($first_date == date('d/m/Y', $d)) {
                                                  $find_day = array_search(date('l', $d), $days);
                                                  echo date('d-M',$d + ((count($days)-$find_day)*86400));
                                              } else { ?>
                                            <!-- --><?php echo date('d-M',$d+518400); ?>
                                            <?php } ?>
                                            <!-- -->
                                          </div>
                                        </div>
                                     </div>
                                </td>
                                
                            <?php } 
                            
                             if($first_date == date('d/m/Y', $d)) {
                                $find_day = array_search(date('l', $d),$days);
                                
                                for($mc = 0; $mc < $find_day; $mc++){ 
                                
                                if(rows(query("select sn from gametime_delhi where market='$market'")) == 0){
                                ?>
                                                  
                                    <td class="thChartResult tdChartOrange">
                                      <div class="divPanna">
                                        <div class="text-xxs">***</div>
                                        <div class="fontResult">**</div>
                                        <div class="text-xxs">
                                          <!-- -->***
                                        </div>
                                      </div>
                                    </td>
                                
                              <?php } else { ?>
                              
                                <td class="thChartResult tdChartOrange">
                                      <div class="divPanna">
                                        <div class="text-xxs"></div>
                                        <div class="fontResult">**</div>
                                        <div class="text-xxs">
                                          <!-- -->
                                        </div>
                                      </div>
                                    </td>
                              
                              <?php } }
                                                  
                                                  
                            }
                            
                             if(isset($data[date('d/m/Y', $d)])) {
                                if(rows(query("select sn from gametime_delhi where market='$market'")) == 0) {
                                     if($data[date('d/m/Y', $d)]['open_panna'] == "") {
                                     $data[date('d/m/Y', $d)]['open_panna'] = "***";
                                    }
                                     if($data[date('d/m/Y', $d)]['open'] == "") {
                                         $data[date('d/m/Y', $d)]['open'] = "*";
                                     }

                                     if($data[date('d/m/Y', $d)]['close'] == "") {
                                         $data[date('d/m/Y', $d)]['close'] = "*";
                                     }

                                     if($data[date('d/m/Y', $d)]['close_panna'] == "") {
                                         $data[date('d/m/Y', $d)]['close_panna'] = "***";
                                     }
                                }
                             ?>
                                 
                                        
                                        
                                <td class="thChartResult tdChartOrange">
                                  <div class="divPanna">
                                    <div class="text-xxs"><?php echo $data[date('d/m/Y', $d)]['open_panna']; ?></div>
                                    <div class="fontResult"><?php echo $data[date('d/m/Y', $d)]['open']; ?><?php echo $data[date('d/m/Y', $d)]['close']; ?></div>
                                    <div class="text-xxs">
                                      <!-- --><?php echo $data[date('d/m/Y', $d)]['close_panna']; ?>
                                    </div>
                                  </div>
                                </td>
                                
                                 
                            <?php } else {
                            
                               
                               if(rows(query("select sn from gametime_delhi where market='$market'")) == 0){
                                ?>
                                                  
                                    <td class="thChartResult tdChartOrange">
                                      <div class="divPanna">
                                        <div class="text-xxs">***</div>
                                        <div class="fontResult">**</div>
                                        <div class="text-xxs">
                                          <!-- -->***
                                        </div>
                                      </div>
                                    </td>
                                
                              <?php } else { ?>
                              
                                <td class="thChartResult tdChartOrange">
                                      <div class="divPanna">
                                        <div class="text-xxs"></div>
                                        <div class="fontResult">**</div>
                                        <div class="text-xxs">
                                          <!-- -->
                                        </div>
                                      </div>
                                    </td>
                              
                              <?php } ?>
                            
                    <?php  } if(date('l', $d) == "Sunday"){ echo "</tr>"; }  }   ?>
                </tbody>
              </table>
            </div>
           
          </div>
        </div>
       
      </div>
    </div>
    
  </body>
</html>