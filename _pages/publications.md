---
layout: page
permalink: /publications/
title: publications
description:
years: [2021, 2020, 2019, 2018, 2017, 2016, 2015, 2014]
nav: true
---
<p class="desc">
list of my publications in reversed chronological order. You can also find me on 
  <a href="https://scholar.google.com/citations?user={{ site.scholar_userid }}" target="_blank" title="Google Scholar">Google Scholar&nbsp;<i class="ai ai-google-scholar" style="display:inline"></i></a> 
and 
  <a href="{{ site.dblp_url }}" target="_blank" title="DBLP">DBLP&nbsp;<i class="ai ai-dblp" style="display:inline"></i></a>
</p>

<div class="publications">

{% for y in page.years %}
  <h2 class="year">{{y}}</h2>
  {% bibliography -f papers -q @*[year={{y}}]* %}
{% endfor %}

</div>
