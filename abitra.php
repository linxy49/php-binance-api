<?php
require_once('const.php');
require_once('vendor/autoload.php');

$api = new Binance\API($key, $secret, ['useServerTime'=>true]);
$api->useServerTime();

// start time
$start = microtime(true);


$percent = [];
$ticker = $api->prices();
$bookticker = $api->bookPrices();

//****************************************************************************//
// Revenues rate
//****************************************************************************//
foreach($symbol['BTC'] as $obj => $min) {

    // 1.BTC->ETH->target coin->BTC
    // ask eth (ETHBTC) -> ask target coin (XXXETH) -> bid target coin (XXXBTC)
    $askEthBtc = $bookticker['ETHBTC']['ask'];
    $askObjEth = $bookticker[ $obj . 'ETH']['ask'];
    $bidObjBTC = $bookticker[ $obj . 'BTC']['bid'];

    // 2.BTC->target coin->ETH->BTC
    // ask target coin (XXXBTC) -> bid target coin (xxxETH) ->bid eth (ETHBTC)
    $askObjBTC = $bookticker[ $obj . 'BTC']['ask'];
    $bidObjEth = $bookticker[ $obj . 'ETH']['bid'];
    $bidEthBtc = $bookticker['ETHBTC']['bid'];


}
















//****************************************************************************//
// 1.ETH->BTC->target coin->ETH
// 2.ETH->target coin->BTC->ETH
//****************************************************************************//
$ethBtc = $bookticker['ETHBTC']['ask'];
foreach($symbol['ETH'] as $sc => $amount) {
    $eth = $bookticker[$sc . 'ETH']['ask'];
    $btc = $bookticker[$sc . 'BTC']['ask'];
    $toEth = bcdiv($btc, $ethBtc, 6);

    $trade = [];
    if ($toEth > $eth
        && $toEth > bcmul($eth, 1.01, 6)) {
        $tmpPercent = bcmul(($toEth-$eth)/$eth, 100, 5);
        $step1['pair'] = $sc . 'ETH';
        $step1['price'] = $eth;
        $step1['amount'] = $symbol['ETH'][$sc];
        $step1['asks'] = $bookticker[$step1['pair']]['asks'];
        $step1['total'] = bcmul($step1['price'], $step1['asks'], 6);
        $trade[0] = $step1;

        $step2['pair'] = $sc . 'BTC';
        $step2['price'] = $btc;
        $step2['amount'] = $symbol['BTC'][$sc];
        $step2['asks'] = $bookticker[$step2['pair']]['asks'];
        $step2['total'] = bcdiv(bcmul($step2['price'], $step2['asks'], 6), $ethBtc, 6);
        $trade[1] = $step2;

        $step3['pair'] = 'ETHBTC';
        $step3['price'] = $ethBtc;
        $step3['amount'] = $symbol['BTC']['ETH'];
        $step3['asks'] = $bookticker[$step3['pair']]['asks'];
        $step3['total'] = bcdiv(bcmul($step3['price'], $step3['asks'], 6), $ethBtc, 6);
        $trade[2] = $step3;
        $percent[$tmpPercent] = $trade;



    } elseif ($eth > $toEth
        && $eth > bcmul($toEth, 1.01, 6)) {
        $tmpPercent = bcmul(($eth-$toEth)/$toEth, 100, 5);
        $step1['pair'] = 'ETHBTC';
        $step1['price'] = $ethBtc;
        $step1['amount'] = $symbol['BTC']['ETH'];
        $step1['asks'] = $bookticker[$step1['pair']]['asks'];
        $step1['total'] = $step1['asks'];
        $trade[0] = $step1;

        $step2['pair'] = $sc . 'BTC';
        $step2['price'] = $btc;
        $step2['amount'] = $symbol['BTC'][$sc];
        $step2['asks'] = $bookticker[$step2['pair']]['asks'];
        $step2['total'] = bcdiv(bcmul($step2['price'], $step2['asks'], 6), $ethBtc, 6);
        $trade[1] = $step2;

        $step3['pair'] = $sc . 'ETH';
        $step3['price'] = $eth;
        $step3['amount'] = $symbol['ETH'][$sc];
        $step3['asks'] = $bookticker[$step3['pair']]['asks'];
        $step3['total'] = bcmul($step3['price'], $step3['asks'], 6);
        $trade[2] = $step3;

        $percent[$tmpPercent] = $trade;
    }
}

// max pair
krsort($percent);
$tKey = '';
$tObj = [];
foreach($percent as $key => $obj) {
    $tKey = $key;
    $tObj = $obj;
    break;
}
echo "(" . $tKey . "%)" . PHP_EOL;
echo $tObj[0]['pair'] . '->' . $tObj[1]['pair'] . '->' . $tObj[2]['pair'] . PHP_EOL;

print_r($tObj[0]);

print_r($tObj[1]);

print_r($tObj[2]);

// ETH AMOUNT
$amt = 0.02;

// STEP1
// if ('ETHBTC' === strval($tObj[0]['pair'])) {
//     bcmul($tObj[0]['price'], 0.02, 6)
// }

// STEP2


// STEP3

// processing time
$end = microtime(true);
echo "processing time:" . ($end - $start) . " second" . PHP_EOL;
