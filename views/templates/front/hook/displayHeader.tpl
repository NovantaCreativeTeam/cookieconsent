{literal}<script type="text/javascript">{/literal}
    window.cc_config = {$config|unescape nofilter};
    {if $force_analytics}
      window.cc_force_analytics = {$force_analytics|unescape nofilter}
    {/if}
{literal}</script>{/literal}

{if $theme eq 'dark'}
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
  document.documentElement.classList.add('cc--darkmode');
});
</script>
{/if}
