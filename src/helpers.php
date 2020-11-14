<?php

if (!function_exists('paymix')) 
{
    /**
     * @param $method
     * @return \RServices\PayMix\Payments\PaymentRepositoryInterface
     */
    function paymix($method)
    {
        return \RServices\PayMix\PayMix::create($method)->getRepository();
    }
}

if (!function_exists('paymixHandle')) 
{
    /**
     * @param $method
     * @return mixed|\RServices\PayMix\Objects\PaymentResponseType
     */
    function paymixHandle($method)
    {
        return \RServices\PayMix\PayMix::create($method)->getRepository()->handleRequest(request());
    }
}