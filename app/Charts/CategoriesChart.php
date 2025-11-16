<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class CategoriesChart
{
    protected $chart;
    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($data, $label): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setWidth(410)
            ->setHeight(height: 410)
            ->addData($data)
            ->setSparkline()
            ->setDataLabels(true)
            ->setLabels($label);
    }
}
