<?php

/**
 * Get best trade root by book ticker
 */
function getBestTradeRootByBookTicker($ccy, $bookticker)
{
    // BTC -> ETH -> CCY -> BTC
    $askEthBtc = $bookticker['ETHBTC']['ask'];      // 1ETH(ETH_BTC)
    $askCcyEth = $bookticker[$ccy . 'ETH']['ask'];  // 1CCY(CCY_ETH)
    $bidCcyBtc = $bookticker[$ccy . 'BTC']['bid'];  // 1CCY(CCY_BTC)

    $difCcyBtc = bcmul($askCcyEth, $askEthBtc, 8);
    if ($bidCcyBtc > $difCcyBtc) {
        $rate = bcmul(($bidCcyBtc-$difCcyBtc)/$difCcyBtc, 1, 8);
        if (0 < $rate) {
            print_r('BTC -> ETH -> ' . $ccy . ' -> BTC' . PHP_EOL);
            print_r($bidCcyBtc . PHP_EOL);
            print_r($difCcyBtc . PHP_EOL);
            print_r($rate*100 . '%' . PHP_EOL);
            // return true;
        }

    }

    // // $base -> $target -> $ex -> $base
    // $askCcyBtc = $bookticker[$ccy . 'BTC']['ask'];  // 1CCY(CCY_BTC)
    // $bidCcyEth = $bookticker[$ccy . 'ETH']['bid'];  // 1CCY(CCY_ETH)
    // $bidEthBtc = $bookticker['ETHBTC']['bid'];      // 1ETH(ETH_BTC)
    //
    // $difCcyBtc = bcmul($bidCcyEth, $bidEthBtc, 8);
    // if ($difCcyBtc > $askCcyBtc) {
    //     $rate = bcmul(($difCcyBtc-$askCcyBtc)/$askCcyBtc, 1, 8);
    //     if (0 < $rate) {
    //         print_r('BTC -> ' . $ccy . ' -> ETH -> BTC' . PHP_EOL);
    //         print_r($askCcyBtc . PHP_EOL);
    //         print_r($difCcyBtc . PHP_EOL);
    //         print_r($rate*100 . '%' . PHP_EOL);
    //         return true;
    //     }
    // }
    // return false;
}

// /**
//  * Get best trade root by ticker(fail)
//  * order does not excute
//  */
// function getBestTradeRootByTicker($ccy, $ticker)
// {
//     $result = [];
//
//     $ethBtc = $ticker['ETHBTC'];
//     $ccyEth = $ticker[$ccy . 'ETH'];
//     $ccyBtc = $ticker[$ccy. 'BTC'];
//
//     $tarCcy = bcmul($ccyEth, $ethBtc, 8);
//
//     // $base -> $ex -> $target -> $base
//     if ($ccyBtc > $tarCcy) {
//         $rate = bcmul(($ccyBtc-$tarCcy)/$tarCcy, 1, 5);
//         if (0.01 < $rate) {
//             $result['rate']  = $rate;
//             $result['trade'] = 'BTC -> ETH -> ' . $ccy . ' -> BTC';
//             $result['steps'] = [];
//
//             $step1['pairs'] = 'ETHBTC';
//             $step1['price'] = $ethBtc;
//             $step1['order'] = true;
//
//             $step2['pairs'] = $ccy . 'ETH';
//             $step2['price'] = $ccyEth;
//             $step2['order'] = true;
//
//             $step3['pairs'] = $ccy . 'BTC';
//             $step3['price'] = $ccyBtc;
//             $step3['order'] = false;
//
//             $result['steps']['1'] = $step1;
//             $result['steps']['2'] = $step2;
//             $result['steps']['3'] = $step3;
//         }
//     }
//
//     $base -> $target -> $ex -> $base
//     if ($tarCcy > $ccyBtc) {
//         $rate = bcmul(($tarCcy-$ccyBtc)/$ccyBtc, 1, 5);
//         if (0.01 < $rate) {
//             $result['rate']  = $rate;
//             $result['trade'] = 'BTC -> ' . $ccy . ' -> ETH -> BTC';
//             $result['steps'] = [];
//
//             $step1['pairs'] = $ccy . 'BTC';
//             $step1['price'] = $ccyBtc;
//             $step1['order'] = true;
//
//             $step2['pairs'] = $ccy . 'ETH';
//             $step2['price'] = $ccyEth;
//             $step2['order'] = false;
//
//             $step3['pairs'] = 'ETHBTC';
//             $step3['price'] = $ethBtc;
//             $step3['order'] = false;
//
//             $result['steps']['1'] = $step1;
//             $result['steps']['2'] = $step2;
//             $result['steps']['3'] = $step3;
//         }
//     }
//     return $result;
// }
