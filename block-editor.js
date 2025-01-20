const { registerBlockType } = wp.blocks;

registerBlockType('theme/content-gate-cta', {
    title: 'Content Gate CTA',
    icon: 'admin-generic',
    category: 'widgets',
    edit: () => wp.element.createElement('p', {}, 'Content Gate CTA Sidebar Block'),
    save: () => null, // Server-side rendering
});
