import { Form, Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { register } from '@/routes';
import verificationCode from '@/routes/verification/code';

type Props = {
    status?: string;
    email?: string | null;
};

export default function VerifyEmail({ status, email }: Props) {
    const [resendCountdown, setResendCountdown] = useState(30);
    const canResend = Boolean(email) && resendCountdown === 0;

    useEffect(() => {
        if (!email) {
            setResendCountdown(0);
            return;
        }

        setResendCountdown(30);
    }, [email, status]);

    useEffect(() => {
        if (resendCountdown === 0) {
            return;
        }

        const timer = window.setTimeout(() => {
            setResendCountdown((seconds) => Math.max(seconds - 1, 0));
        }, 1000);

        return () => window.clearTimeout(timer);
    }, [resendCountdown]);

    return (
        <>
            <Head title="Verify email" />

            <div className="space-y-6">
                {status === 'verification-code-sent' && (
                    <div className="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        Kode verifikasi baru sudah dikirim ke email Anda.
                    </div>
                )}

                <Form
                    action={verificationCode.store.url()}
                    method="post"
                    className="space-y-6"
                >
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-2">
                                <Label htmlFor="email">Email address</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    defaultValue={email ?? ''}
                                    required
                                    autoFocus={!email}
                                    autoComplete="email"
                                    placeholder="email@example.com"
                                />
                                <InputError message={errors.email} />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor="code">Verification code</Label>
                                <Input
                                    id="code"
                                    type="text"
                                    name="code"
                                    required
                                    autoFocus={Boolean(email)}
                                    inputMode="numeric"
                                    maxLength={6}
                                    autoComplete="one-time-code"
                                    placeholder="6 digit code"
                                />
                                <InputError message={errors.code} />
                            </div>

                            <Button
                                type="submit"
                                className="w-full"
                                disabled={processing}
                            >
                                {processing && <Spinner />}
                                Verify email
                            </Button>
                        </>
                    )}
                </Form>

                <Form
                    action={verificationCode.resend.url()}
                    method="post"
                    onSuccess={() => setResendCountdown(30)}
                    className="space-y-3"
                >
                    {({ processing }) => (
                        <>
                            <input
                                type="hidden"
                                name="email"
                                value={email ?? ''}
                            />

                            <Button
                                type="submit"
                                variant="secondary"
                                className="w-full"
                                disabled={processing || !canResend}
                            >
                                {processing && <Spinner />}
                                {resendCountdown > 0
                                    ? `Resend code in ${resendCountdown}s`
                                    : 'Resend verification code'}
                            </Button>
                        </>
                    )}
                </Form>

                <div className="space-y-2 text-center text-sm text-muted-foreground">
                    <div>
                        Already verified? <TextLink href={login()}>Log in</TextLink>
                    </div>
                    <div>
                        Need a new account?{' '}
                        <TextLink href={register()}>Sign up</TextLink>
                    </div>
                </div>
            </div>
        </>
    );
}

VerifyEmail.layout = {
    title: 'Verify your email',
    description:
        'Enter the 6 digit verification code that was sent to your email address.',
};
