{literal}<script type="text/javascript">{/literal}
    window.cc_config = {$config nofilter};
{literal}</script>{/literal}

{if $theme eq 'dark'}
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
  document.body.classList.toggle('c_darkmode');
});
</script>
{/if}
