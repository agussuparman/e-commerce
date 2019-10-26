<?php

function appendQueryString($params) {
    $query = Request::all();
    foreach ($params as $key => $value) {
        $query[$key] = $value;
    }
    return Request::url(). '?' . http_build_query($query);
}

function isQueryStringEqual($params) {
    return !array_diff($params, Request::all());
}

function bankList()
{
	$result = [];
	foreach (config('bank-accounts') as $account => $detail) {
		$result[$account] = $detail['title'];
	}
	return $result;
}