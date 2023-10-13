includes
========
Every page at thpmne opens and closes is built on 4 basic includes:
* setup - open $_SESSION, check permissions, set up basic routines
* start_page - output the html head with CDN links to CSS, and open the body and main divs
* navbar - the menu, included by start_page
* end_page - close the body and load js files from CDN.

Pages for data entry utilize a range of additional subroutines
* edit_head - this is included after setup but before start_page

In addition, there are a few alternative versions of these files
* start/end dashboard - the black-formatted pages that lead each section
* start/end datatable - alternate javascript for client-side sorting
* start_nonav - just like start_page but with no navigation bar, used in bd/field for staff field entry webapp
