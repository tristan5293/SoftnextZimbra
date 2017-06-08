<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class SyncXMLParser extends Controller
{
    public function XMLParserToView(Request $request){
        $contents = Storage::get('/opt/zimbra/conf/ldapsync.xml');
        $simplexml = simplexml_load_string($contents);
        $master_url = $simplexml->masterURL;
        $master_filter = $simplexml->masterFilter;
        $master_search_base = $simplexml->masterSearchBase;
        $master_bind_user = $simplexml->masterBindUser;
        $master_bind_password = $simplexml->masterBindPassword;
        $master_bind_timeout = $simplexml->masterBindTimeout;
        $log_level = $simplexml->logLevel;
        $local_ignore = $simplexml->localIgnore;
        $master_ignore = $simplexml->masterIgnore;
        $attribute_map_attr_displayName = $simplexml->attributeMap->attr['master'][0];

        return view('zimbra.ldapsync', ['master_url' => $master_url,
                                        'master_filter' => $master_filter,
                                        'master_search_base' => $master_search_base,
                                        'master_bind_user' => $master_bind_user,
                                        'master_bind_password' => $master_bind_password,
                                        'master_bind_timeout' => $master_bind_timeout,
                                        'log_level' => $log_level,
                                        'local_ignore' => $local_ignore,
                                        'master_ignore' => $master_ignore,
                                        'attribute_map_attr_displayName' => $attribute_map_attr_displayName]);
    }

    public function DataSaveToSyncXML(Request $request){
        $master_url = $request->input('master_url');
        $master_filter = $request->input('master_filter');
        $master_search_base = $request->input('master_search_base');
        $master_bind_user = $request->input('master_bind_user');
        $master_bind_password = $request->input('master_bind_password');
        $master_bind_timeout = $request->input('master_bind_timeout');
        $log_level = $request->input('log_level');
        $local_ignore = $request->input('local_ignore');
        $master_ignore = $request->input('master_ignore');
        $attribute_map_attr_displayName = $request->input('attribute_map_attr_displayName');

        $contents = Storage::get('/opt/zimbra/conf/ldapsync.xml');
        $simplexml = simplexml_load_string($contents);
        $simplexml->masterURL = $master_url;
        $simplexml->masterFilter = $master_filter;
        $simplexml->masterSearchBase = $master_search_base;
        $simplexml->masterBindUser = $master_bind_user;
        $simplexml->masterBindPassword = $master_bind_password;
        $simplexml->masterBindTimeout = $master_bind_timeout;
        $simplexml->logLevel = $log_level;
        $simplexml->localIgnore = $local_ignore;
        $simplexml->masterIgnore = $master_ignore;
        $simplexml->attributeMap->attr[0]->attributes()->master = $attribute_map_attr_displayName;
        Storage::put('/opt/zimbra/conf/ldapsync.xml', $simplexml->asXML());
        return '設定完成';
    }
}
