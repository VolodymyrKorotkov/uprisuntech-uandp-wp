import classNames from "classnames";
import React, { useState } from "react";
import styles from "./Item.module.scss";
import global from "../../../../../../../../App.module.scss";
import { Modal } from "@mui/material";
import I18n from "../../../../../../../I18n/I18n";
const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'https://staging-ndp.netvision.pro';
function Item({item, addItemCart}) {
	const [open, setOpen] = useState(false);
	return (
		<>
			<Modal
				className={classNames(global.c_modal_flex, global.c_modal_mob)}
				open={open}
				onClose={() => {
					setOpen(false);
				}}>
				<div className={classNames(global.c_modal, global.c_modal_full)}>
					<div className={global.c_modal_header}>
						<div className={global.semi}>
							PH1800 PLUS Series (2-5.5KW)
						</div>
						<div className={classNames(global.c_modal_close, global.static)}>
							<svg
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none"
								xmlns="http://www.w3.org/2000/svg"
							>
								<path
									d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
									fill="#919094"
								/>
							</svg>
						</div>
					</div>
					<div className={global.c_modal_body}>
						<div className={styles.card}>
							<div className={styles.card_wrap}>
								<div className={styles.card_indent}>
									<div className='row'>
										<div className='col-lg-6'>
											<div className={styles.card_slider}>
												<img src="/wp-content/themes/vh_ndp/react-aplication/build/img/card.png" alt="alt" />
											</div>
										</div>
										<div className='col-lg-6'>
											<div className={styles.card_descr}>
												<div className={styles.card_name}>
													{item.name}
												</div>
												<div className={styles.card_logo}>
													<div
														className={
															styles.card_logo_text
														}
													>
														Solar inverters
													</div>
													<img src="/wp-content/themes/vh_ndp/react-aplication/build/img/card-log.png" alt="alt" />
												</div>
												<p className={styles.card_descr_text}>
													{item.short_description}
												</p>
												<div className={styles.alert}>
													<div
														className={styles.alert_header}
													>
														<svg
															width="20"
															height="20"
															viewBox="0 0 20 20"
															fill="none"
															xmlns="http://www.w3.org/2000/svg"
														>
															<path
																fill-rule="evenodd"
																clip-rule="evenodd"
																d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z"
																fill="#2A59BD"
															/>
														</svg>
														<span>How it works</span>
													</div>
													<p>
														This section contains information about the vendors and solutions presented on the platform. Once you have selected several solutions, you can compare them with each other or add them to your funding application.
													</p>
												</div>
											</div>
										</div>
									</div>
									<div className="row">
										<div className="col-lg-6 mb-4 mb-lg-0">
											<div className={styles.card_info}>
												<div className={styles.card_seo}>
													<h3>About solution</h3>
													<p>
														PH1800 Plus series hybrid solar
														inverter, it can realize
														self-consumption and feed-in to
														the grid from solar energy with
														best solution according to your
														setting. During the daytime
														solar power can run your home
														appliances and if there is extra
														solar power it will feed-in to
														the grid or you can choose to
														save them on the battery to
														backup when power failure or
														nighttime.
													</p>
													<ul>
														<li>Pure sine wave output</li>
														<li>
															Self-consumption and Feed-in
															to the grid
														</li>
														<li>
															Programmable supply priority
															for PV, Battery or Grid
														</li>
														<li>
															User-adjustable battery
															charging current suits
															different types of batteries
														</li>
														<li>
															Programmable multiple
															operation modes: Grid-tie,
															off-grid and grid-tie with
															backup
														</li>
														<li>
															Monitoring software & Wifi
															Kit for real-time status
															display and control
														</li>
														<li>
															Parallel operation up to 3
															units
														</li>
													</ul>
												</div>
												<a href="#" className={classNames(global.btns, global.btns_link)}>
													<span>Vendor website</span>
													<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
														<mask id="mask0_3810_40622" style={{ maskType: "alpha" }} maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18">
															<rect width="18" height="18" fill="#D9D9D9"/>
														</mask>
														<g mask="url(#mask0_3810_40622)">
															<path d="M4.0502 15.2992C3.67895 15.2992 3.36113 15.167 3.09676 14.9027C2.83238 14.6383 2.7002 14.3205 2.7002 13.9492V4.04922C2.7002 3.67797 2.83238 3.36016 3.09676 3.09578C3.36113 2.83141 3.67895 2.69922 4.0502 2.69922H9.0002V4.04922H4.0502V13.9492H13.9502V8.99922H15.3002V13.9492C15.3002 14.3205 15.168 14.6383 14.9036 14.9027C14.6393 15.167 14.3214 15.2992 13.9502 15.2992H4.0502ZM7.25645 11.6992L6.3002 10.743L12.9939 4.04922H10.8002V2.69922H15.3002V7.19922H13.9502V5.00547L7.25645 11.6992Z" fill="#2A59BD"/>
														</g>
													</svg>
												</a>
											</div>
										</div>
										<div className="col-lg-6">
											<div className={styles.card_info}>
												<div className={styles.prop}>
													<h3 className={global.h3_24}>Properties</h3>
													<div className={styles.prop_box}>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Nominal Battery System Voltage</div>
															<div className={styles.semi}>24VDC</div>
														</div>
													</div>
													<div className={styles.prop_box}>
														<div className={styles.prop_head}>Inverter output</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Rated Power</div>
															<div className={styles.semi}>2000W</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Surge Power</div>
															<div className={styles.semi}>4000W</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Waveform</div>
															<div className={styles.semi}>Pure Sine Wave</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>AC Voltage Regulation (Batt.Mode)</div>
															<div className={styles.semi}>220VAC~240VAC(setting)</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Electric Current</div>
															<div className={styles.semi}>8.7A</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Inverter Efficiency(Peak)</div>
															<div className={styles.semi}>93%</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Transfer Time</div>
															<div className={styles.semi}>10ms(UPS /VDE4105 ) 20ms( APL)</div>
														</div>
													</div>
													<div className={styles.prop_box}>
														<div className={styles.prop_head}>AC input</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Voltage</div>
															<div className={styles.semi}>230VAC</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Selectable Voltage Range</div>
															<div className={styles.semi}>170~280VAC(UPS), 90~280VAC(APL), 184~253VAC(VDE4105)</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Frequency Range</div>
															<div className={styles.semi}>50Hz / 60Hz (Auto Sensing)</div>
														</div>
													</div>
													<div className={styles.prop_box}>
														<div className={styles.prop_head}>Battery</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Normal Voltage</div>
															<div className={styles.semi}>24VDC</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Floating Charge Voltage</div>
															<div className={styles.semi}>27.4VDC</div>
														</div>
														<div className={styles.prop_row}>
															<div className={styles.gray}>Overcharge Protection</div>
															<div className={styles.semi}>30VDC</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div className={global.c_modal_footer}>
						<div
							className={classNames(
								global.c_modal_nav,
								"justify-content-end"
							)}
						>
							<div
								className={classNames(
									global.btns,
									global.btns_blue
								)}
							>
								Add to solution
							</div>
						</div>
					</div>
				</div>
			</Modal>
			<div className={styles.solutions}>
				<a
					className={styles.solutions_img}
					href={"/product/" + item.slug}
					target="_blank"
				>
					<img
						src={item?.images[0]?.src ||  domain + '/wp-content/themes/vh_ndp/assets/img/home/no-image.jpg'}
						alt={item?.images[0]?.name}
						onError={e => (e.target.src = domain + '/wp-content/themes/vh_ndp/assets/img/home/no-image.jpg')} 
					/>
				</a>
				<div className={styles.solutions_content}>
					<a href={"/product/" + item.slug}
						className={styles.solutions_head}
						target="_blank"
					>
						{item.name}
					</a>
					<div className={styles.solutions_text}>{(item?.short_description || item?.description || item?.yoast_head_json?.og_description || '').replace(/<.*?>/g, '')}</div>
					<button href="#" className={classNames(
							global.btns,
							global.btns_blue,
							styles.btn,
							// {[styles.disabled]: !item.on_sale}
						)} onClick={() => addItemCart(item)}><I18n text='Add to application'/></button>
				</div>
			</div>
		</>
	);
}

export default Item;
