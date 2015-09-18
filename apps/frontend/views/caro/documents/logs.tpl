<h3>Custom Logs</h3>
<p>Use:</p>

<p>Log message|array|exist object</p>
<pre>
    \Modules\Backend\Models\CaroLogs::log([message], [log_file(default:caro)]);
</pre>

<p>Log object</p>
<pre>
    \Modules\Backend\Models\CaroLogs::logObject([object], [log_file (default: caro)]);
</pre>

<p>Check Logs</p>
<pre>/apps/logs/[log_file]</pre>