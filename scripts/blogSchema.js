{
  "@context": "http:\\/\\/schema.org\\/",
  "@type": "BlogPosting",
  "name": "<?php wp_title(); ?>",
  "url": "https://betterdeveloperdocs.com/",
  "articleBody": "<? echo get_field('seo_meta_description', $post->ID)); ?>",
  "headline": "<?php wp_title(); ?>",
  "author": {
    "@type": "Person",
    "name": "Vinay Lal",
    "url": "https://www.vinaylal.co/"
  },
  "datePublished": "<?php echo get_the_date(); ?>",
  "mainEntityOfPage": "True",
  "dateModified": "<?php echo get_the_modified_date(); ?>",
  "image": {
    "@type": "ImageObject",
    “url”: “https://betterdeveloperdocs.com/wp-content/uploads/2022/09/wordpress-logo-logok-5-compress.png”,
    “height”: 600,
    “width”: 447
  },
  "publisher": {
    "@context": "http:\\/\\/schema.org\\/",
    "@type": "Organization",
    "name": "Better Developer Docs",
    "logo": {
      "@type": "ImageObject",
      "url": "https://betterdeveloperdocs.com/wp-content/uploads/2022/09/wordpress-logo-logok-5-compress.png",
      "height": 600,
      "width": 447
    }
  }
}