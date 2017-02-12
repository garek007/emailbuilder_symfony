<?php
//$utm_campaign = $_REQUEST['utm_campaign'];
//$utm_source = $_REQUEST['utm_source'];
//$utm_medium = $_REQUEST['utm_medium'];

?>
<form class="moduleform" title="tttdform" name="tttdform" action="layouts/events/make-layout.php" method="post">


      <input name="utm_source" type="hidden" id="utm_source" size="30" value="<?php //echo $utm_source; ?>">
      <input name="utm_medium" type="hidden" id="utm_medium" value="<?php //echo $utm_medium; ?>" size="30">
      <input name="utm_campaign" type="hidden" id="utm_campaign" value="<?php //echo $utm_campaign; ?>" size="30">




<div class="row"> 
<div class="first-col cols_12-8">
 <label for="blogposturl">Blog Post URL (Top Things to Do ONLY)</label>
  <input name="blogposturl" type="text" id="blogposturl" size="30">
  </div>
  </div>

<div class="row">


<table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainTable" class="events inputTable">
  <tbody>   
    <tr>
      <th valign="top" bgcolor="#DADADA" class="rowlabel">#</th>
      <th valign="top" bgcolor="#DADADA" class="title">Event Title</th>
      <th valign="top" bgcolor="#DADADA" class="month">Event Line 1</th>
      <th valign="top" bgcolor="#DADADA" class="date">Event Line 2</th>
      <th valign="top" bgcolor="#DADADA" class="url" id="firstrow">Event URL</th>
      <th valign="top" bgcolor="#DADADA" class="content">Ad Content<br><span class="small">Enter 3-4 words max to identify your event in Google Analytics.</span></th>
    </tr>
    {% for i in 1..16 %}
    <tr>
			<td class="rowlabel">{{ i }}</td>
      <td class="title"><input class="text" name="title[]" type="text" id="textfield" size="25"></td>
      <td class="month"><input class="text" name="month[]" type="text" id="textfield" size="7"></td>
      <td class="date"><input class="text" name="date[]" type="text" id="textfield" size="7"></td>
      <td class="url"><input class="text" name="dest_url[]" type="text" id="textfield" size="85"></td>
      <td class="content"><input class="text" name="ad_content[]" type="text" id="textfield" size="25"></td>
    </tr>
  {% endfor %}
       
  </tbody>
</table>
<input type="submit" value="Generate HTML" class="button">
</div>

</form>
