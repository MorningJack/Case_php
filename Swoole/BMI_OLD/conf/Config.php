<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 2017/3/2
 * Time: 16:51
 * Email: 1183@mapgoo.net
 */
return array(
    'ICE' => array(
        //集群地址
        'IceGrid' => 'Mapgoo-Server/Locator:default -h 172.16.1.86 -p 22000:default -h 172.16.1.87 -p 22001:default -h 172.16.1.90 -p 22002',
        //RDP链接端口配置
        'RDP' => array(
            'Session' => 'RealDataSession',
            'MessageSizeMax' => 0,
        ),
        //CAP链接端口配置
        'CAP' => array(
            'Session' => 'CacheSession',
            'MessageSizeMax' => 0,
        ),
        //DAP链接端口配置
        'DAP' => array (
            'Session' => 'DAPSession',
            'MessageSizeMax' => 0,
        ),
        //MFS链接端口配置
        'MFS' => array (
            'Session' => 'MFSSession',
            'MessageSizeMax' => 0,
        ),
        //OSS链接端口配置
        'OSS' => array (
            'Session' => 'OSSSession',
            'MessageSizeMax' => 0,
        ),
        //RARS链接端口配置
        'RARS' => array (
            'Session' => 'RARSSession',
            'MessageSizeMax' => 0,
        ),
        //MRS链接端口配置
        'MRS' => array (
            'Session' => 'CmdPackSession',
            'MessageSizeMax' => 0,
        ),
        //SSV链接端口配置
        'SSV' => array (
            'Session' => 'SSVProxySession',
            'MessageSizeMax' => 0,
        ),
        'MFSNAS' => array (
            'Session' => 'MFSSession:tcp -p 10051 -h 172.16.1.88',
            'MessageSizeMax' => 0,
        ),
        'MFSIDC' => array (
            'Session' => 'MFSSession:tcp -p 20052 -h 183.62.138.118',
            'MessageSizeMax' => 0,
        ),
        'ASS' => array (
            'Session' => 'ASSSession',
            'MessageSizeMax' => 0,
        ),
        'TRACE' => array (
            'Session' => 'TraceSession',
            'MessageSizeMax' => 0,
        )
    )
);
