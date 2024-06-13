{literal}<script type="text/javascript">{/literal}
    window.cc_config = {$config|unescape nofilter};
{literal}</script>{/literal}

{if $theme eq 'dark'}
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
  document.documentElement.classList.add('cc--darkmode');
});
</script>
{/if}
