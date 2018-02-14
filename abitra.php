<?php
require_once('const.php');
require_once('config.php');
require_once('helper.php');
require_once('vendor/autoload.php');

$api = new Binance\API($key, $secret, ['useServerTime'=>true]);
$api->useServerTime();

// start time
$start = microtime(true);

$percent = [];
$ticker = $api->prices();
$bookticker = $api->bookPrices();

//****************************************************************************//
// best trade root base btc
//****************************************************************************//
$array = [];
// foreach($symbol['BTC'] as $ccy => $min) {
//     if (in_array($ccy, $except)) {
//         continue;
//     }
//     $result = getBestTradeRootByTicker($ccy, $ticker);
//     if (!empty($result)) {
//         $array[$result['rate']] = $result;
//     }
// }
//
// if (!empty($array)) {
//     krsort($array);
//     $rate = 0;
//     $steps = "";
//     foreach($array as $key => $obj) {
//         $rate = '(' . $key*100 . '%)' . $obj['trade'];
//         $steps = $obj['steps'];
//         break;
//     }
//
//     print_r($rate . PHP_EOL);

    // /*
    //  * STEP1
    //  *
    //  * BTC -> ETH (ask)
    //  * @TODO BTC -> CCY (ask)
    //  */
    // // $am1 = bcdiv(0.002, $ticker[$steps["1"]['pairs']], intval($symbol['BTC'][str_replace('BTC', '', $steps["1"]['pairs'])]));
    // // $res1 = [];
    // // $res1 = $api->buy($steps["1"]['pairs'], $am1, $steps["1"]['price']);
    // // print_r($steps["1"]['pairs'] . PHP_EOL);
    // // print_r($am1 . PHP_EOL);
    // // print_r($steps["1"]['price'] . PHP_EOL);
    // // print_r($res1);

    // /*
    //  * STEP2
    //  *
    //  * ETH -> CCY (ask)
    //  * @TODO CCY -> ETH (bid)
    //  */
    // $am2 = bcdiv(0.02, $ticker[$steps["2"]['pairs']], intval($symbol['ETH'][str_replace('ETH', '', $steps["2"]['pairs'])]));
    // // $am2 = bcdiv($res1['executedQty'], $ticker[$steps["2"]['pairs']], intval($symbol['ETH'][str_replace('ETH', '', $steps["2"]['pairs'])]));
    // $res2 = [];
    // if ($steps["2"]['order']) {
    //     // buy
    //     $res2 = $api->buy($steps["2"]['pairs'], $am2, $steps["2"]['price']);
    // } else {
    //     // sell
    //     $res2 = $api->sell($steps["2"]['pairs'], $am2, $steps["2"]['price']);
    // }
    // print_r($steps["2"]['pairs'] . PHP_EOL);
    // print_r($am2 . PHP_EOL);
    // print_r($steps["2"]['price'] . PHP_EOL);
    // print_r($res2);
    //
    // /*
    //  * STEP3
    //  *
    //  * CCY -> BTC (bid)
    //  * @TODO ETH -> BTC (bid)
    //  */
    // $am3 = $res2['executedQty'];
    // $res3 = [];
    // $res3 = $api->sell($steps["3"]['pairs'], $am3, $steps["3"]['price']);
    // print_r($steps["3"]['pairs'] . PHP_EOL);
    // print_r($am3 . PHP_EOL);
    // print_r($steps["3"]['price'] . PHP_EOL);
    // print_r($res3);

// }







foreach($symbol['BTC'] as $ccy => $min) {
    if (in_array($ccy, $except)) {
        continue;
    }

    getBestTradeRootByBookTicker($ccy, $bookticker);
}














//****************************************************************************//
// 1.ETH->BTC->target coin->ETH
// 2.ETH->target coin->BTC->ETH
//****************************************************************************//
// $ethBtc = $bookticker['ETHBTC']['ask'];
// foreach($symbol['ETH'] as $sc => $amount) {
//     $eth = $bookticker[$sc . 'ETH']['ask'];
//     $btc = $bookticker[$sc . 'BTC']['ask'];
//     $toEth = bcdiv($btc, $ethBtc, 6);
//
//     $trade = [];
//     if ($toEth > $eth
//         && $toEth > bcmul($eth, 1.01, 6)) {
//         $tmpPercent = bcmul(($toEth-$eth)/$eth, 100, 5);
//         $step1['pair'] = $sc . 'ETH';
//         $step1['price'] = $eth;
//         $step1['amount'] = $symbol['ETH'][$sc];
//         $step1['asks'] = $bookticker[$step1['pair']]['asks'];
//         $step1['total'] = bcmul($step1['price'], $step1['asks'], 6);
//         $trade[0] = $step1;
//
//         $step2['pair'] = $sc . 'BTC';
//         $step2['price'] = $btc;
//         $step2['amount'] = $symbol['BTC'][$sc];
//         $step2['asks'] = $bookticker[$step2['pair']]['asks'];
//         $step2['total'] = bcdiv(bcmul($step2['price'], $step2['asks'], 6), $ethBtc, 6);
//         $trade[1] = $step2;
//
//         $step3['pair'] = 'ETHBTC';
//         $step3['price'] = $ethBtc;
//         $step3['amount'] = $symbol['BTC']['ETH'];
//         $step3['asks'] = $bookticker[$step3['pair']]['asks'];
//         $step3['total'] = bcdiv(bcmul($step3['price'], $step3['asks'], 6), $ethBtc, 6);
//         $trade[2] = $step3;
//         $percent[$tmpPercent] = $trade;
//
//
//
//     } elseif ($eth > $toEth
//         && $eth > bcmul($toEth, 1.01, 6)) {
//         $tmpPercent = bcmul(($eth-$toEth)/$toEth, 100, 5);
//         $step1['pair'] = 'ETHBTC';
//         $step1['price'] = $ethBtc;
//         $step1['amount'] = $symbol['BTC']['ETH'];
//         $step1['asks'] = $bookticker[$step1['pair']]['asks'];
//         $step1['total'] = $step1['asks'];
//         $trade[0] = $step1;
//
//         $step2['pair'] = $sc . 'BTC';
//         $step2['price'] = $btc;
//         $step2['amount'] = $symbol['BTC'][$sc];
//         $step2['asks'] = $bookticker[$step2['pair']]['asks'];
//         $step2['total'] = bcdiv(bcmul($step2['price'], $step2['asks'], 6), $ethBtc, 6);
//         $trade[1] = $step2;
//
//         $step3['pair'] = $sc . 'ETH';
//         $step3['price'] = $eth;
//         $step3['amount'] = $symbol['ETH'][$sc];
//         $step3['asks'] = $bookticker[$step3['pair']]['asks'];
//         $step3['total'] = bcmul($step3['price'], $step3['asks'], 6);
//         $trade[2] = $step3;
//
//         $percent[$tmpPercent] = $trade;
//     }
// }
//
// // max pair
// krsort($percent);
// $tKey = '';
// $tObj = [];
// foreach($percent as $key => $obj) {
//     $tKey = $key;
//     $tObj = $obj;
//     break;
// }
// echo "(" . $tKey . "%)" . PHP_EOL;
// echo $tObj[0]['pair'] . '->' . $tObj[1]['pair'] . '->' . $tObj[2]['pair'] . PHP_EOL;
//
// print_r($tObj[0]);
//
// print_r($tObj[1]);
//
// print_r($tObj[2]);
//
// // ETH AMOUNT
// $amt = 0.02;

// STEP1
// if ('ETHBTC' === strval($tObj[0]['pair'])) {
//     bcmul($tObj[0]['price'], 0.02, 6)
// }

// STEP2


// STEP3

// end time
$end = microtime(true);

// processing time
echo "processing time:" . ($end - $start) . " second" . PHP_EOL;
