import { mount } from '@vue/test-utils';
import GeneratePayments from '@/components/GeneratePayments.vue';

describe('GeneratePayments.vue', () => {
  it('displays generated data when form is submitted', async () => {
    const wrapper = mount(GeneratePayments);

    // Simulate user input and form submission
    await wrapper.setData({ outputFile: '/path/to/output/file.csv' });
    await wrapper.find('form').trigger('submit.prevent');

    // Assert the expected behavior
    expect(wrapper.find('.generated-data').isVisible()).toBe(true);
    expect(wrapper.find('.generated-data pre').text()).toContain('Generated data:');
    
  });
});
