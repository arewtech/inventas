<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class AssetBorrowingsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($data, $label): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setWidth(375)
            ->setHeight(height: 375)
            ->addData($data)
            ->setSparkline()
            ->setDataLabels(true)
            ->setLabels($label);
    }
}
