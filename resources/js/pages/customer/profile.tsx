import { Form, Head, Link } from '@inertiajs/react';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import customerProfile from '@/routes/customer/profile';
import { dashboard } from '@/routes';

type Customer = {
    identify_type: string | null;
    identity_number: string | null;
    address: string | null;
    city: string | null;
    province: string | null;
};

type Props = {
    customer: Customer | null;
    status?: string;
};

export default function CustomerProfile({ customer, status }: Props) {
    return (
        <>
            <Head title="Customer profile" />

            <div className="mx-auto max-w-2xl space-y-6">
                <Heading
                    title="Complete your customer profile"
                    description="This step is optional for now. You can skip it and update your customer details later."
                />

                {status === 'customer-profile-saved' && (
                    <div className="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        Your customer profile has been saved.
                    </div>
                )}

                {status === 'customer-profile-skipped' && (
                    <div className="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                        You skipped this step. You can complete your customer profile later.
                    </div>
                )}

                <Form
                    action={customerProfile.update.url()}
                    method="put"
                    className="space-y-6"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-6 md:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="identify_type">
                                        Identity type
                                    </Label>
                                    <Input
                                        id="identify_type"
                                        name="identify_type"
                                        defaultValue={
                                            customer?.identify_type ?? ''
                                        }
                                        placeholder="KTP, Passport, SIM"
                                    />
                                    <InputError message={errors.identify_type} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="identity_number">
                                        Identity number
                                    </Label>
                                    <Input
                                        id="identity_number"
                                        name="identity_number"
                                        defaultValue={
                                            customer?.identity_number ?? ''
                                        }
                                        placeholder="Your identity number"
                                    />
                                    <InputError
                                        message={errors.identity_number}
                                    />
                                </div>
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="address">Address</Label>
                                <textarea
                                    id="address"
                                    name="address"
                                    defaultValue={customer?.address ?? ''}
                                    placeholder="Your full address"
                                    className="min-h-28 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none transition-[color,box-shadow] placeholder:text-muted-foreground focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50"
                                />
                                <InputError message={errors.address} />
                            </div>

                            <div className="grid gap-6 md:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="city">City</Label>
                                    <Input
                                        id="city"
                                        name="city"
                                        defaultValue={customer?.city ?? ''}
                                        placeholder="City"
                                    />
                                    <InputError message={errors.city} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="province">Province</Label>
                                    <Input
                                        id="province"
                                        name="province"
                                        defaultValue={customer?.province ?? ''}
                                        placeholder="Province"
                                    />
                                    <InputError message={errors.province} />
                                </div>
                            </div>

                            <div className="flex flex-col gap-3 sm:flex-row">
                                <Button disabled={processing}>
                                    Save customer profile
                                </Button>

                                <Link
                                    href={customerProfile.skip()}
                                    method="post"
                                    as="button"
                                    className="inline-flex items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium shadow-xs transition-[color,box-shadow] hover:bg-accent hover:text-accent-foreground"
                                >
                                    Skip for now
                                </Link>

                                <Link
                                    href={dashboard()}
                                    className="inline-flex items-center justify-center text-sm text-muted-foreground underline underline-offset-4"
                                >
                                    Go to dashboard
                                </Link>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

CustomerProfile.layout = {
    title: 'Customer profile',
    description:
        'Complete your customer information now, or skip and update it later.',
};
