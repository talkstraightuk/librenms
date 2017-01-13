<?php


if (starts_with($sysDescr, 'Linux')) {
    $os = 'linux';

    // Specific Linux-derivatives
    if (starts_with($sysObjectId, array('.1.3.6.1.4.1.5528.100.20.10.2014', '.1.3.6.1.4.1.5528.100.20.10.2016'))) {
        $os = 'netbotz';
    } elseif (str_contains($sysDescr, 'endian')) {
        $os = 'endian';
    } elseif (str_contains($sysDescr, 'Cisco Small Business')) {
        $os = 'ciscosmblinux';
    } elseif (str_contains(snmp_get($device, 'ENTITY-MIB::entPhysicalMfgName.1', '-Osqnv'), 'QNAP')) {
        $os = 'qnap';
    } elseif (starts_with($sysObjectId, '.1.3.6.1.4.1.15397.2')) {
        $os = 'procera';
    } elseif (starts_with($sysObjectId, array('.1.3.6.1.4.1.10002.1', '.1.3.6.1.4.1.41112.1.4')) || str_contains(snmp_get($device, 'dot11manufacturerName.5', '-Osqnv', 'IEEE802dot11-MIB'), 'Ubiquiti')) {
        $os = 'airos';
        if (str_contains(snmp_walk($device, 'dot11manufacturerProductName', '-Osqnv', 'IEEE802dot11-MIB'), 'UAP')) {
            $os = 'unifi';
        } elseif (snmp_get($device, 'fwVersion.1', '-Osqnv', 'UBNT-AirFIBER-MIB', 'ubnt') !== false) {
            $os = 'airos-af';
        }
    } elseif (snmp_get($device, 'GANDI-MIB::rxCounter.0', '-Osqnv', 'GANDI-MIB') !== false) {
        $os = 'pktj';
    } elseif (starts_with($sysObjectId, '.1.3.6.1.4.1.40310')) {
        $os = 'cumulus';
    } elseif (snmp_get($device, 'SFA-INFO::systemName.0', '-Osqnv', 'SFA-INFO') !== false) {
        $os = 'ddnos';
    } elseif (is_numeric(trim(snmp_get($device, 'roomTemp.0', '-OqvU', 'CAREL-ug40cdz-MIB', 'carel')))) {
        $os = 'pcoweb'; // Carel PCOweb
    } elseif (starts_with($sysDescr, 'Linux mirthtemplate')) {
        $os = 'mirth';
    } elseif ($wrt = snmp_get($device, '.1.3.6.1.4.1.2021.7890.1.101.1', '-Osqnv')) {
        $wrt = trim($wrt, '"');
        if (starts_with($wrt, 'ASUSWRT-Merlin')) {
            $os = 'asuswrt-merlin';
        } elseif (starts_with($wrt, 'Tomato ')) {
            $os = 'tomato';
        }
    }
}
